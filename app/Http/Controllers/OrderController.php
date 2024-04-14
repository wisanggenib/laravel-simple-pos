<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\order_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    //order
    public function order(Request $request)
    {

        //check avaibility stock
        $cart_products = collect(request()->session()->get('cart'));
        if (session('cart')) {
            foreach ($cart_products as $key => $product) {
                $cekData = Product::find($key);
                $query_pending_stock = DB::select('SELECT sum(quantity) as available_stock 
                            FROM order_details od 
                            JOIN orders o 
                            ON o.id = od.id_order 
                            WHERE MONTH(o.created_at) = MONTH(CURRENT_DATE()) 
                            AND YEAR(o.created_at) = YEAR(CURRENT_DATE()) 
                            AND (o.status = "order"
                                 OR o.status  = "proses" )
                            AND od.id_product  = ?', [$key]);
                $pending_stock = $query_pending_stock[0]->available_stock;
                $avalable_stock = $cekData->product_stock - $pending_stock;

                if ($avalable_stock < $product['quantity']) {
                    $cart = session()->get('cart');
                    if (isset($cart[$key])) {
                        $cart[$key]['quantity'] = $avalable_stock;
                        session()->put('cart', $cart);
                    }
                    return response()->json([
                        'status' => 400,
                        'message' => 'error',
                        'data' => $cekData->product_stock
                    ]);
                }
            }
        }


        $cart_products = collect(request()->session()->get('cart'));

        $cart_total = 0;
        if (session('cart')) {
            foreach ($cart_products as $key => $product) {

                $cart_total += $product['quantity'] * $product['price'];
            }
        }

        $ID_USER = Auth::user()->id;
        $orders = new Order();
        $orders->id_user = $ID_USER;
        $orders->status = 'order';
        $orders->total = $cart_total;
        $orders->save();


        if ($orders->id) {
            $cart_products = collect(request()->session()->get('cart'));
            if (session('cart')) {
                foreach ($cart_products as $key => $product) {
                    if ($product['quantity'] > 0) {
                        $detailOrders = new order_detail();
                        $detailOrders->id_order = $orders->id;
                        $detailOrders->id_product = $key;
                        $detailOrders->product_name = $product['product_name'];
                        $detailOrders->price = $product['price'];
                        $detailOrders->quantity = $product['quantity'];
                        $detailOrders->thumbnail = $product['image'];
                        $detailOrders->save();
                    }
                }
            }
        }

        if ($orders) {
            $AA = $request->session()->forget('cart');
            return response()->json([
                'status' => 200,
                'message' => 'success create',
                'data' => $orders
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'error',
                'data' => $orders
            ]);
        }
    }

    public function fetch()
    {
        $cutoff =
            DB::table('orders')
            ->select('orders.*', 'users.id as id_users')
            ->join('users', 'orders.id_user', '=', 'users.id')
            ->where('orders.id_user', Auth::user()->id)
            ->get();
        return response()->json([
            'cutoffs' => $cutoff,
        ]);
    }

    public function fetchDetail($id)
    {
        $product =
            DB::table('orders')
            ->select('order_details.*', 'orders.*', 'orders.id as id')
            ->join('order_details', 'order_details.id_order', '=', 'orders.id')
            ->where('orders.id', $id)
            ->get();

        if ($product) {
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $product
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'error',
                'data' => null
            ]);
        }
    }

    public function fetchAdmin()
    {
        $orders =
            DB::table('users')
            ->select('users.*', 'users.id as id_users', 'areas.*', 'areas.id as id_area', 'orders.*', 'orders.id as id')
            ->join('orders', 'orders.id_user', '=', 'users.id')
            ->join('areas', 'areas.id', '=', 'users.id_area')
            // ->where('orders.id_user', Auth::user()->id)
            ->get();

        return view('/admin/order', compact('orders'));
    }

    public function viewDetail($id)
    {
        // $users = User::paginate(10);
        $orders =
            DB::table('orders')
            ->select('users.*', 'users.id as id_users', 'orders.*')
            ->join('users', 'users.id', '=', 'orders.id_user')
            ->where('orders.id', $id)
            ->first();

        $user =
            DB::table('users')
            ->select('areas.*', 'areas.id as id_area', 'users.*')
            ->join('areas', 'areas.id', '=', 'users.id_area')
            ->where('users.id', Auth::user()->id)
            ->first();

        $products =
            DB::table('order_details')
            ->select('orders.*', 'orders.id as id_order', 'order_details.*')
            ->join('orders', 'orders.id', '=', 'order_details.id_order')
            ->where('order_details.id_order', $id)
            ->get();

        return view('detail-order', compact('products', 'orders', 'user'));
    }

    public function prosesBarang(Request $request, $id)
    {

        $cutOff = Order::find($id);
        if ($cutOff) {
            $cutOff->status = 'proses';
            $cutOff->update();
            if ($cutOff) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success update',
                    'data' => $cutOff
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'data not found',
                'data' => null
            ]);
        }
    }

    public function kirimBarang(Request $request, $id)
    {
        $products =
            DB::table('order_details')
            ->select('orders.*', 'orders.id as id_order', 'order_details.*')
            ->join('orders', 'orders.id', '=', 'order_details.id_order')
            ->where('order_details.id_order', $id)
            ->get();

        foreach ($products as $key => $product) {
            $currProduct = Product::find($product->id_product);
            $currProduct->product_stock = $currProduct->product_stock - $product->quantity;
            $currProduct->update();
        }

        $cutOff = Order::find($id);
        if ($cutOff) {

            if ($request->file('thumbnail')) {
                $ext = $request->file('thumbnail')->extension();
                $imgName = date("Ymdhis") . '.' . $ext;
                Storage::putFileAs('public/images', $request->file('thumbnail'), $imgName);
                $cutOff->resi = $imgName;
            }
            $cutOff->tgl_kirim = now();
            $cutOff->status = 'kirim';
            $cutOff->update();
            if ($cutOff) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success update',
                    'data' => $cutOff
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'data not found',
                'data' => null
            ]);
        }
    }

    public function tolakBarang(Request $request, $id)
    {

        $cutOff = Order::find($id);
        if ($cutOff) {
            $cutOff->status = 'tolak';
            $cutOff->update();
            if ($cutOff) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success update',
                    'data' => $cutOff
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'data not found',
                'data' => null
            ]);
        }
    }

    public function terimaBarang(Request $request, $id)
    {

        $cutOff = Order::find($id);
        if ($cutOff) {

            if ($request->file('thumbnail')) {
                $ext = $request->file('thumbnail')->extension();
                $imgName = date("Ymdhis") . '.' . $ext;
                Storage::putFileAs('public/images', $request->file('thumbnail'), $imgName);
                $cutOff->bukti_terima = $imgName;
            }
            $cutOff->tgl_diterima = now();
            $cutOff->status = 'selesai';
            $cutOff->update();
            if ($cutOff) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success update',
                    'data' => $cutOff
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'data not found',
                'data' => null
            ]);
        }
    }
}
