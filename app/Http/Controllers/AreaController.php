<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AreaController extends Controller
{
    //

    public function index()
    {
        $areas = Areas::latest()->paginate(1);
        return view('admin.area', compact('areas'));
    }

    public function fetchData($name = "")
    {
        $areas = Areas::latest()->where('areas.area_name', 'LIKE', "%$name%")->paginate(10000000);
        return response()->json([
            'areas' => $areas,
        ]);
    }

    public function show()
    {
        foreach (Areas::all() as $flight) {
            echo $flight->area_name;
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'area_name' => ['required', 'unique:areas'],
        ]);

        $areaModel = new Areas;
        $areaModel->area_name = $request->input('area_name');
        $areaModel->area_budget = $request->input('area_budget');
        $areaModel->area_location = $request->input('area_location');
        $areaModel->save();

        if ($areaModel) {
            return response()->json([
                'status' => 200,
                'message' => 'success fetch',
                'data' => $areaModel
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'failed',
                'data' => $areaModel
            ]);
        }



        // return redirect()
        //     ->route('area.index')
        //     ->with('message', 'Area Berhasil dibuat');
    }

    public function fetchDetail($id)
    {

        $area = Areas::find($id);
        if ($area) {
            return response()->json([
                'status' => 200,
                'message' => 'success fetch',
                'data' => $area
            ]);
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

        $area = Areas::find($id);
        if ($area) {
            $area->area_name = $request->input('area_name');
            $area->area_budget = $request->input('area_budget');
            $area->area_location = $request->input('area_location');
            $area->update();
            if ($area) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success update',
                    'data' => $area
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
        $area = Areas::find($id);
        $area->delete();
        if ($area) {
            if ($area) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success delete',
                    'data' => $area
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
