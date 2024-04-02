<?php

namespace App\Http\Controllers;

use App\Models\CutOff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CutOffController extends Controller
{
    public function fetchData()
    {
        $cutoff =
            DB::table('cut_offs')
            ->select('cut_offs.*', 'areas.area_name')
            ->join('areas', 'cut_offs.id_area', '=', 'areas.id')
            ->paginate(10);
        return response()->json([
            'cutoffs' => $cutoff,
        ]);
    }

    public function store(Request $request)
    {
        if (CutOff::where('id_area', $request->input('area'))->exists()) {
            return response()->json([
                'status' => 200,
                'message' => 'error',
                'data' => "Area Duplicate"
            ]);
        }


        $cutOff = new CutOff();
        $cutOff->id_area = $request->input('area');
        $cutOff->startDate = $request->input('startDate');
        $cutOff->endDate = $request->input('endDate');
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

    public function fetchDetail($id)
    {

        $cutOff = CutOff::find($id);
        // // dd($cutOff->id_area);
        // $startDate = strtotime($cutOff->startDate);
        // $endDate = strtotime($cutOff->endDate);
        // $formatStartDate = date('m/d/Y', $startDate);
        // $formatEndDate = date('m/d/Y', $endDate);
        // dd($formatStartDate . ' - ' . $formatEndDate);

        if ($cutOff) {
            return response()->json([
                'status' => 200,
                'message' => 'success fetch',
                'data' => $cutOff
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
        $cutOff = CutOff::find($id);
        $cutOff->delete();
        if ($cutOff) {
            if ($cutOff) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success delete',
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

    public function updateData(Request $request, $id)
    {
        $cutOff = CutOff::find($id);
        if ($request->input('area') != $cutOff->id_area) {
            if (CutOff::where('id_area', $request->input('area'))->exists()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'error',
                    'data' => "Area Duplicate"
                ]);
            }
        }
        if ($cutOff) {
            $cutOff->id_area = $request->input('area');
            $cutOff->startDate = $request->input('startDate');
            $cutOff->endDate = $request->input('endDate');
            $cutOff->update();
            if ($cutOff) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success update',
                    'data' => $cutOff
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'error update',
                    'data' => null
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
