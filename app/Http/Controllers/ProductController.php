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
        $cart = session()->get('cart', []);
        $cart[$productId] = [
            'name' => $product->product_name,
            'price' => $product->product_price,
            'thumbnail' => $product->thumbnail,
            'qty' => $request->input('productQTY'),
        ];
        // session('cart')->forget($cart[$productId]);
        // session()->pull('cart', $cart[$productId]);

        session()->put('cart', $cart);
    }
}
