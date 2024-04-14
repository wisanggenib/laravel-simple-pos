<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function fetchData()
    {
        $products =
            DB::table('products')
            ->select('product_categories.id as id_category', 'product_categories.*', 'products.*')
            ->join('product_categories', 'products.id_category', '=', 'product_categories.id')
            ->paginate(10);
        return response()->json([
            'products' => $products,
        ]);
    }

    public function fetchDetail($id)
    {

        $products =
            DB::table('products')
            ->select('product_categories.id as id_category', 'product_categories.*', 'products.*')
            ->join('product_categories', 'products.id_category', '=', 'product_categories.id')
            ->where('products.id', $id)
            ->first();
        if ($products) {
            return response()->json([
                'status' => 200,
                'message' => 'success fetch',
                'data' => $products
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'data not found',
                'data' => null
            ]);
        }
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'product_name' => 'required',
            'product_stock' => 'required',
            'product_type' => 'required',
            'product_price' => 'required',
            'product_description' => 'required',
        ]);


        $ext = $request->file('thumbnail')->extension();
        $imgName = date("Ymdhis") . '.' . $ext;
        Storage::putFileAs('public/images', $request->file('thumbnail'), $imgName);

        $cutOff = new Product();
        $cutOff->product_name = $request->input('product_name');
        $cutOff->product_stock = $request->input('product_stock');
        $cutOff->product_type = $request->input('product_type');
        $cutOff->product_price = $request->input('product_price');
        $cutOff->id_category = $request->input('id_category');
        $cutOff->product_description = $request->input('product_description');
        $cutOff->thumbnail = $imgName;
        $cutOff->is_vendor = $request->input('is_vendor');
        if ($request->input('is_vendor') === "true") {
            $cutOff->vendor_name = $request->input('vendor_name');
        } else {
            $cutOff->vendor_name = "-";
        }
        $cutOff->save();

        if ($cutOff) {
            return response()->json([
                'status' => 200,
                'message' => 'success create',
                'data' => $cutOff
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'error',
                'data' => $cutOff
            ]);
        }
    }

    public function updateData(Request $request, $id)
    {

        $cutOff = Product::find($id);
        if ($cutOff) {
            $cutOff->product_name = $request->input('product_name');
            $cutOff->product_stock = $request->input('product_stock');
            $cutOff->product_type = $request->input('product_type');
            $cutOff->product_price = $request->input('product_price');
            $cutOff->id_category = $request->input('id_category');
            $cutOff->product_description = $request->input('product_description');
            $cutOff->is_vendor = $request->input('is_vendor');
            if ($request->input('is_vendor') === "true") {
                $cutOff->vendor_name = $request->input('vendor_name');
            } else {
                $cutOff->vendor_name = "-";
            }
            if ($request->file('thumbnail')) {
                $ext = $request->file('thumbnail')->extension();
                $imgName = date("Ymdhis") . '.' . $ext;
                Storage::putFileAs('public/images', $request->file('thumbnail'), $imgName);
                $cutOff->thumbnail = $imgName;
            }
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

    public function deleteData($id)
    {
        $productCategories = Product::find($id);
        $productCategories->delete();
        if ($productCategories) {
            if ($productCategories) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success delete',
                    'data' => $productCategories
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

    public function viewDetail($id)
    {
        // $users = User::paginate(10);
        $products =
            DB::table('products')
            ->select('product_categories.id as id_category', 'product_categories.*', 'products.*')
            ->join('product_categories', 'products.id_category', '=', 'product_categories.id')
            ->where('products.id', $id)
            ->first();

        $id_category = $products->id_category;
        $id = $products->id;

        $products2 = DB::select('SELECT product_categories.id as id_category, product_categories.*, products.* FROM products JOIN product_categories ON products.id_category = product_categories.id WHERE products.id_category = ? AND products.id != ? LIMIT 4', [$id_category, $id]);

        return view('detail-product', compact('products', 'products2'));
    }

    public function addCart(Request $request)
    {
        $productId = $request->input('productID');
        $product = Product::find($productId);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $cart[$product->id]['quantity'] + $request->input('productQTY');
        } else {
            $cart[$productId] = [
                "product_name" => $product->product_name,
                "quantity" => $request->input('productQTY'),
                "price" => $product->product_price,
                "image" => $product->thumbnail,
                "id" => $productId
            ];
        }

        $AA = $request->session()->put('cart', $cart);

        return response()->json([
            'status' => 200,
            'message' => 'data not found',
            'data' => $AA
        ]);
    }

    public function showCart()
    {
        $cart_products = collect(request()->session()->get('cart'));

        $cart_total = 0;
        if (session('cart')) {
            foreach ($cart_products as $key => $product) {

                $cart_total += $product['quantity'] * $product['price'];
            }
        }

        /*dd($cart_total);*/
        // $products = Product::has('images')->with('images')->latest()->limit(10)->get();
        // $total_products_count = request()->session()->get('cart') ? count(request()->session()->get('cart')) : 0;
        // return view('cart', compact('cart_products', 'cart_total', 'total_products_count'));
        return view('cart', compact('cart_products', 'cart_total'));
    }

    public function deleteCart($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {

            unset($cart[$id]);
        }
        session()->put('cart', $cart);
        return redirect('/cart')->with('message', 'Area Berhasil dibuat');
    }
}
