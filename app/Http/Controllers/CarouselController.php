<?php

namespace App\Http\Controllers;

use App\Models\Carousels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    //
    public function fetchData()
    {
        $cutoff =
            DB::table('carousels')
            ->select('carousels.*')
            ->paginate(5);
        return response()->json([
            'carousels' => $cutoff,
        ]);
    }

    public function fetchID($id)
    {
        $product =
            DB::table('carousels')
            ->select('carousels.*')
            ->where('carousels.id', $id)
            ->first();

        if ($product) {
            return response()->json([
                'status' => 200,
                'message' => 'success fetch',
                'data' => $product
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
        $imgName = 'crsl_' . date("Ymdhis") . '.' . $ext;
        Storage::putFileAs('public', $request->file('thumbnail'), $imgName);

        $cutOff = new Carousels();
        $cutOff->gambar = $imgName;
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

        $cutOff = Carousels::find($id);
        if ($cutOff) {
            if ($request->file('thumbnail')) {
                $ext = $request->file('thumbnail')->extension();
                $imgName = 'crsl_' . date("Ymdhis") . '.' . $ext;
                Storage::putFileAs('public', $request->file('thumbnail'), $imgName);
                $cutOff->gambar = $imgName;
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
        $productCategories = Carousels::find($id);
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
}
