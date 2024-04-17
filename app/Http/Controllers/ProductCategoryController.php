<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    //
    public function fetchData()
    {
        $productCategory = ProductCategory::latest()->paginate(5);
        return response()->json([
            'product_categories' => $productCategory,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoryName' => 'required',
            'images' => 'required',
        ]);

        $ext = $request->file('images')->extension();
        $imgName = date("Ymdhis") . '.' . $ext;
        Storage::putFileAs('public/images', $request->file('images'), $imgName);

        $productCategories = new ProductCategory();
        $productCategories->product_category_name = $request->input('categoryName');
        $productCategories->images = $imgName;
        $productCategories->save();

        if ($productCategories) {
            return response()->json([
                'status' => 200,
                'message' => 'success create',
                'data' => $productCategories
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'error',
                'data' => $productCategories
            ]);
        }
    }

    public function updateData(Request $request, $id)
    {

        $productCategories = ProductCategory::find($id);
        if ($productCategories) {
            $productCategories->product_category_name = $request->input('categoryName');
            if ($request->file('images')) {
                $ext = $request->file('images')->extension();
                $imgName = date("Ymdhis") . '.' . $ext;
                Storage::putFileAs('public/images', $request->file('images'), $imgName);
                $productCategories->images = $imgName;
            }
            $productCategories->update();
            if ($productCategories) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success update',
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

    public function fetchDetail($id)
    {

        $productCategories = ProductCategory::find($id);
        if ($productCategories) {
            return response()->json([
                'status' => 200,
                'message' => 'success fetch',
                'data' => $productCategories
            ]);
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
        $productCategories = ProductCategory::find($id);
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

    public function fetchAllData()
    {
        $productCategory = ProductCategory::latest()->get();
        return response()->json([
            'product_categories' => $productCategory,
        ]);
    }
}
