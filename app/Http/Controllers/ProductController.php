<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function fetchData()
    {
        $cutoff =
            DB::table('products')
            ->select('products.*', 'product_categories.id as id_category')
            ->join('product_categories', 'cut_offs.id_area', '=', 'areas.id')
            ->paginate(10);
        return response()->json([
            'cutoffs' => $cutoff,
        ]);
    }
}
