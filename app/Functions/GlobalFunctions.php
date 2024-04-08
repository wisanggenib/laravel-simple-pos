<?php

use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function users_count()
{
    $ID_USER = Auth::user()->id;
    $cutoff =
        DB::table('users')
        ->select('users.*', 'areas.area_name', 'areas.area_budget')
        ->join('areas', 'users.id_area', '=', 'areas.id')
        ->where('users.id', $ID_USER)
        ->first();

    return $cutoff->area_budget;
}


function format_date($data)
{
    return date_format($data, "Y/m/d H:i");
}
