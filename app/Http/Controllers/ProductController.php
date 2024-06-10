<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;
use stdClass;

class ProductController extends Controller
{

    public function fetchData($value = "")
    {
        $products =
            DB::table('products')
            ->select('product_categories.id as id_category', 'product_categories.*', 'products.*')
            ->join('product_categories', 'products.id_category', '=', 'product_categories.id')
            ->where('products.product_name', 'LIKE', "%$value%")
            ->paginate(100);

        foreach ($products as $key => $value) {
            $query_pending_stock = DB::select('SELECT sum(quantity) as available_stock 
                            FROM order_details od 
                            JOIN orders o 
                            ON o.id = od.id_order 
                            WHERE MONTH(o.created_at) = MONTH(CURRENT_DATE()) 
                            AND YEAR(o.created_at) = YEAR(CURRENT_DATE()) 
                            AND (o.status = "order"
                                 OR o.status  = "proses" )
                            AND od.id_product  = ?', [$value->id]);
            $pending_stock = $query_pending_stock[0]->available_stock;
            $avalable_stock = $value->product_stock - $pending_stock;
            $value->available_stock = $avalable_stock;
        }

        return response()->json([
            'products' => $products,
        ]);
    }

    public function fetchMinus()
    {
        $products =
            DB::table('products')
            ->select('product_categories.id as id_category', 'product_categories.*', 'products.*')
            ->join('product_categories', 'products.id_category', '=', 'product_categories.id')
            ->where('is_vendor', '=', 'false')
            ->get();

        foreach ($products as $key => $value) {
            $query_pending_stock = DB::select('SELECT sum(quantity) as available_stock 
                            FROM order_details od 
                            JOIN orders o 
                            ON o.id = od.id_order 
                            WHERE MONTH(o.created_at) = MONTH(CURRENT_DATE()) 
                            AND YEAR(o.created_at) = YEAR(CURRENT_DATE()) 
                            AND (o.status = "order"
                                 OR o.status  = "proses" )
                            AND od.id_product  = ?', [$value->id]);
            $pending_stock = $query_pending_stock[0]->available_stock;
            $avalable_stock = $value->product_stock - $pending_stock;
            $value->available_stock = (int)$avalable_stock;
        }

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

        if ($request->input('is_vendor') === "true") {
            $validated = $request->validate([
                'product_name' => 'required',
                'product_type' => 'required',
                'product_price' => 'required',
                'product_description' => 'required',
            ]);
        } else {
            $validated = $request->validate([
                'product_name' => 'required',
                'product_stock' => 'required',
                'product_type' => 'required',
                'product_price' => 'required',
                'product_description' => 'required',
            ]);
        }




        $ext = $request->file('thumbnail')->extension();
        $imgName = date("Ymdhis") . '.' . $ext;
        Storage::putFileAs('public', $request->file('thumbnail'), $imgName);

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
            $cutOff->product_stock = 0;
        } else {
            $cutOff->vendor_name = "-";
            $cutOff->product_stock = $request->input('product_stock');
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
                Storage::putFileAs('public', $request->file('thumbnail'), $imgName);
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

        $query_pending_stock = DB::select('SELECT sum(quantity) as available_stock 
                            FROM order_details od 
                            JOIN orders o 
                            ON o.id = od.id_order 
                            WHERE MONTH(o.created_at) = MONTH(CURRENT_DATE()) 
                            AND YEAR(o.created_at) = YEAR(CURRENT_DATE()) 
                            AND (o.status = "order"
                                 OR o.status  = "proses" )
                            AND od.id_product  = ?', [$id]);
        $pending_stock = $query_pending_stock[0]->available_stock;
        $avalable_stock = $products->product_stock - $query_pending_stock[0]->available_stock;

        $products2 = DB::select('SELECT product_categories.id as id_category, product_categories.*, products.* FROM products JOIN product_categories ON products.id_category = product_categories.id WHERE products.id_category = ? AND products.id != ? AND products.product_stock > 0 LIMIT 4', [$id_category, $id]);

        return view('detail-product', compact('products', 'products2', 'avalable_stock'));
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

    public function updateCart(Request $request)
    {
        $productId = $request->input('productID');
        $product = Product::find($productId);

        $cart = $request->session()->get('cart', []);

        // $cekData = Product::find($request->input('productID'));
        // $query_pending_stock = DB::select('SELECT sum(quantity) as available_stock 
        //                     FROM order_details od 
        //                     JOIN orders o 
        //                     ON o.id = od.id_order 
        //                     WHERE MONTH(o.created_at) = MONTH(CURRENT_DATE()) 
        //                     AND YEAR(o.created_at) = YEAR(CURRENT_DATE()) 
        //                     AND (o.status = "order"
        //                          OR o.status  = "proses" )
        //                     AND od.id_product  = ?', [$request->input('productID')]);
        // $pending_stock = $query_pending_stock[0]->available_stock;
        // $avalable_stock = $cekData->product_stock - $pending_stock;


        if (isset($cart[$product->id])) {
            if ($request->input('status') == 'inc') {
                // if ((int)$avalable_stock < ($cart[$product->id]['quantity'] + 1)) {
                //     return response()->json([
                //         'status' => 200,
                //         'message' => 'error',
                //         'status' => 'error',
                //         'data' => 'Quantity Melebihi Ketersediaan stock'
                //     ]);
                // }
                $cart[$product->id]['quantity'] = $cart[$product->id]['quantity'] + 1;
            } else {
                if (($cart[$product->id]['quantity'] - 1) < 0) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'error',
                        'status' => 'error',
                        'data' => 'Minimum Quantity 0, silahkan hapus data'
                    ]);
                }
                $cart[$product->id]['quantity'] = $cart[$product->id]['quantity'] - 1;
            }
        }

        $AA = $request->session()->put('cart', $cart);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'status' => 'success',
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

    public function dashboardProduct($filter)
    {
        if ($filter == 'all') {
            $products2 = DB::select('select p.product_name,p.id,
                                (select sum(quantity) 
                                    FROM order_details od2 
                                    JOIN orders o 
                                    ON od2.id_order = o.id  
                                    where od2.id_product = p.id
                                    AND (o.status != "tolak" OR o.status = "order")
                                    ) as items_total
                                from products p 
                                JOIN order_details od
                                ON p.id = od.id_product 
                                GROUP BY p.id,p.product_name
                                ORDER BY items_total DESC
                                ');
        } else {
            $products2 = DB::select('select p.product_name,p.id,
                                (select sum(quantity) 
                                    FROM order_details od2 
                                    JOIN orders o 
                                    ON od2.id_order = o.id  
                                    where od2.id_product = p.id
                                    AND (o.status != "tolak" OR o.status = "order")
                                    ) as items_total
                                from products p 
                                JOIN order_details od
                                ON p.id = od.id_product 
                                GROUP BY p.id,p.product_name
                                ORDER BY items_total DESC
                                LIMIT ?
                                ', [(int)$filter]);
        }

        if ($products2) {
            if ($products2) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success fetch',
                    'data' => $products2
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

    public function dashboardVendor()
    {
        $products = DB::select('select p.product_name,p.id as id_product,p.product_price,p.vendor_name,
                                (select sum(quantity) 
                                    FROM order_details od2 
                                    JOIN orders o 
                                    ON od2.id_order = o.id  
                                    where od2.id_product = p.id
                                    AND (o.status != "tolak" OR o.status = "order")
                                    ) as items_total
                                from products p 
                                JOIN order_details od
                                ON p.id = od.id_product 
                                GROUP BY p.id
                                ORDER BY items_total DESC');

        $vendors = DB::select('select DISTINCT(p.vendor_name) from products p WHERE p.vendor_name != "-"');

        foreach ($vendors as $key => $v) {
            $result = collect($products)->where('vendor_name', $v->vendor_name);
            $totals = 0;
            foreach ($result as $key => $value) {
                $totals = $totals + (int)$value->product_price * (int)$value->items_total;
            }
            $object = new stdClass();
            $object->vendor_name = $v->vendor_name;
            $object->totals = $totals;
            $myArray[] = $object;
        }

        if ($vendors) {
            if ($vendors) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success fetch',
                    'data' => $myArray
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

    public function dashboardBudget()
    {
        $products2 = DB::select('select a.area_name, a.area_budget,
                                (SELECT sum(total) as total FROM orders
                                JOIN users u
                                ON u.id = orders.id_user 
                                WHERE MONTH(orders.created_at) = MONTH(CURRENT_DATE())
                                AND YEAR(orders.created_at) = YEAR(CURRENT_DATE())
                                AND u.id_area  = a.id
                                AND (orders.status != "tolak" OR orders.status = "order")) as expenses
                                FROM areas a 
                                ORDER BY expenses ASC
                                ');

        if ($products2) {
            if ($products2) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success fetch',
                    'data' => $products2
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

    public function cartVendor()
    {
        $products = DB::select('select p.product_name,p.id as id_product,p.product_price,p.vendor_name,
                                (select sum(quantity) 
                                    FROM order_details od2 
                                    JOIN orders o 
                                    ON od2.id_order = o.id  
                                    where od2.id_product = p.id
                                    AND (o.status != "tolak" OR o.status = "order")
                                    ) as items_total
                                from products p 
                                JOIN order_details od
                                ON p.id = od.id_product 
                                GROUP BY p.id
                                ORDER BY items_total DESC');

        $vendors = DB::select('select DISTINCT(p.vendor_name) from products p WHERE p.vendor_name != "-"');

        $datas = array();
        $labels = array();
        $background = array();

        foreach ($vendors as $key => $v) {
            $result = collect($products)->where('vendor_name', $v->vendor_name);
            $totals = 0;
            foreach ($result as $key => $value) {
                $totals = $totals + (int)$value->product_price * (int)$value->items_total;
            }
            array_push($labels, $v->vendor_name);
            array_push($datas, $totals);
            array_push($background, random_color());
        }

        $object = new stdClass();
        $object->labels = $labels;
        $object->data = $datas;
        $object->background = $background;

        if ($vendors) {
            if ($vendors) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success fetch',
                    'data' => $object
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

    public function cartBudget()
    {
        $products2 = DB::select('select a.area_name, a.area_budget,
                                (SELECT sum(total) as total FROM orders
                                JOIN users u
                                ON u.id = orders.id_user 
                                WHERE MONTH(orders.created_at) = MONTH(CURRENT_DATE())
                                AND YEAR(orders.created_at) = YEAR(CURRENT_DATE())
                                AND u.id_area  = a.id
                                AND (orders.status != "tolak" OR orders.status = "order")) as expenses
                                FROM areas a 
                                ORDER BY expenses ASC
                                ');
        $datas = array();
        $labels = array();
        $expenses = array();
        $leftover = array();
        foreach ($products2 as $key => $value) {
            array_push($labels, $value->area_name);
            array_push($datas, (int)$value->area_budget);
            array_push($expenses, (int)$value->expenses);
            array_push($leftover, (int)$value->area_budget - (int)$value->expenses);
        }

        $object = new stdClass();
        $object->labels = $labels;
        $object->datas = $datas;
        $object->expenses = $expenses;
        $object->leftover = $leftover;

        if ($products2) {
            if ($products2) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success fetch',
                    'data' => $object
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

    public function priceRange()
    {
        $products2 = DB::select('select min(product_price) as min_price, max(product_price) as max_price from products p');
        if ($products2) {
            if ($products2) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success fetch',
                    'data' => $products2
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

    public function getAllProductFilter($data, $name = "")
    {
        $decodeData = json_decode(urldecode($data));
        $names = json_decode($name);
        $filterByID = "";
        if ($decodeData->id_category != 'All') {
            $filterByID = 'AND p.id_category = "' . $decodeData->id_category . '"';
        }

        $query = "select * from products p WHERE p.product_price  BETWEEN $decodeData->min_price AND $decodeData->max_price $filterByID AND p.product_name LIKE '%$names%'";
        $products2 = DB::select($query);
        if ($products2) {
            if ($products2) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success fetch',
                    'data' => $products2
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

    public function exportExcel()
    {
        $users = DB::select('select p.product_name,p.id,
                                (select sum(quantity) 
                                    FROM order_details od2 
                                    JOIN orders o 
                                    ON od2.id_order = o.id  
                                    where od2.id_product = p.id
                                    AND (o.status != "tolak" OR o.status = "order")
                                    ) as items_total
                                from products p 
                                JOIN order_details od
                                ON p.id = od.id_product 
                                GROUP BY p.id,p.product_name
                                ORDER BY items_total DESC
                                ');

        return (new FastExcel($users))->download('file.xlsx', function ($user) {
            return [
                'Nama Produk' => $user->product_name,
                'Total Produk' => $user->items_total,
            ];
        });
    }

    public function exportExcelProduct()
    {
        $users = DB::select('select p.product_name,p.id,
                                (select sum(quantity) 
                                    FROM order_details od2 
                                    JOIN orders o 
                                    ON od2.id_order = o.id  
                                    where od2.id_product = p.id
                                    AND (o.status != "tolak" OR o.status = "order")
                                    ) as items_total
                                from products p 
                                JOIN order_details od
                                ON p.id = od.id_product 
                                GROUP BY p.id,p.product_name
                                ORDER BY items_total DESC
                                ');

        $datexx = date("Y_m_d_H_i_s");
        return (new FastExcel($users))->download("laporan-produk_" . "$datexx" . ".xlsx", function ($user) {
            return [
                'Nama Produk' => $user->product_name,
                'Total Produk' => $user->items_total,
            ];
        });
    }

    public function exportExcelVendor()
    {
        $products = DB::select('select p.product_name,p.id as id_product,p.product_price,p.vendor_name,
                                (select sum(quantity) 
                                    FROM order_details od2 
                                    JOIN orders o 
                                    ON od2.id_order = o.id  
                                    where od2.id_product = p.id
                                    AND (o.status != "tolak" OR o.status = "order")
                                    ) as items_total
                                from products p 
                                JOIN order_details od
                                ON p.id = od.id_product 
                                GROUP BY p.id
                                ORDER BY items_total DESC');

        $vendors = DB::select('select DISTINCT(p.vendor_name) from products p WHERE p.vendor_name != "-"');

        foreach ($vendors as $key => $v) {
            $result = collect($products)->where('vendor_name', $v->vendor_name);
            $totals = 0;
            foreach ($result as $key => $value) {
                $totals = $totals + (int)$value->product_price * (int)$value->items_total;
            }
            $object = new stdClass();
            $object->vendor_name = $v->vendor_name;
            $object->totals = $totals;
            $myArray[] = $object;
        }

        // dd($myArray);
        $datexx = date("Y_m_d_H_i_s");
        return (new FastExcel($myArray))->download("laporan-vendor_" . "$datexx" . ".xlsx", function ($user) {
            return [
                'Vendor Name' => $user->vendor_name,
                'Total' => $user->totals,
            ];
        });
    }

    public function exportExcelBudget()
    {
        $products2 = DB::select('select a.area_name, a.area_budget,
                                (SELECT sum(total) as total FROM orders
                                JOIN users u
                                ON u.id = orders.id_user 
                                WHERE MONTH(orders.created_at) = MONTH(CURRENT_DATE())
                                AND YEAR(orders.created_at) = YEAR(CURRENT_DATE())
                                AND u.id_area  = a.id
                                AND (orders.status != "tolak" OR orders.status = "order")) as expenses
                                FROM areas a 
                                ORDER BY expenses ASC
                                ');

        // dd($products2);

        $datexx = date("Y_m_d_H_i_s");
        (new FastExcel($products2))->export(storage_path("laporan_budget_" . "$datexx" . ".xlsx"), function ($user) {
            return [
                'Area' => $user->area_name,
                'Budget' => $user->area_budget,
                'Pengeluaran' => $user->expenses
            ];
        });
        return response()->download(storage_path("laporan_budget_" . "$datexx" . ".xlsx"));

        // return Storage::download(Storage::files("laporan_budget_" . "$datexx" . ".xlsx"));
    }

    public function exportExcelHome()
    {
        $products = DB::table('products')
            ->select('product_categories.id as id_category', 'product_categories.*', 'products.*')
            ->join('product_categories', 'products.id_category', '=', 'product_categories.id')
            ->where('is_vendor', '=', 'false')
            ->get();

        foreach ($products as $key => $value) {
            $query_pending_stock = DB::select('SELECT sum(quantity) as available_stock 
                            FROM order_details od 
                            JOIN orders o 
                            ON o.id = od.id_order 
                            WHERE MONTH(o.created_at) = MONTH(CURRENT_DATE()) 
                            AND YEAR(o.created_at) = YEAR(CURRENT_DATE()) 
                            AND (o.status = "order"
                                 OR o.status  = "proses" )
                            AND od.id_product  = ?', [$value->id]);
            $pending_stock = $query_pending_stock[0]->available_stock;
            $avalable_stock = $value->product_stock - $pending_stock;
            $value->available_stock = (int)$avalable_stock;
        }


        $datexx = date("Y_m_d_H_i_s");
        return (new FastExcel($products))->download("laporan_stok_barang_" . "$datexx" . ".xlsx", function ($user) {
            return [
                'Nama Produk' => $user->product_name,
                'Stock Tersedia' => $user->available_stock
            ];
        });
    }
}
