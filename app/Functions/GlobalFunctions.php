<?php

use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function users_count()
{
    $currentExpenses = DB::select('SELECT sum(total) as total FROM orders
                        JOIN users u
                        ON u.id = orders.id_user 
                        WHERE MONTH(orders.created_at) = MONTH(CURRENT_DATE())
                        AND YEAR(orders.created_at) = YEAR(CURRENT_DATE())
                        AND u.id_area  = ?
                        AND orders.status  != "tolak"', [Auth::user()->id_area]);

    $ID_USER = Auth::user()->id;
    $cutoff =
        DB::table('users')
        ->select('users.*', 'areas.area_name', 'areas.area_budget')
        ->join('areas', 'users.id_area', '=', 'areas.id')
        ->where('users.id', $ID_USER)
        ->first();

    return $cutoff->area_budget - (int)$currentExpenses[0]->total;
}

function getStatusCutOff()
{
    $ID_AREA = Auth::user()->id_area;
    $cutoff =
        DB::table('cut_offs')
        ->select('cut_offs.*')
        ->where('cut_offs.id_area', $ID_AREA)
        ->orderBy('updated_at', 'desc')
        ->first();


    if (!$cutoff) {
        $paymentDate = date('Y-m-d');
        $paymentDate = date('Y-m-d', strtotime($paymentDate));

        $currentMonth = date('m');
        $currentYear = date('Y');
        $newStartDateString = "$currentYear-$currentMonth-25";
        $newEndDateString = "$currentYear-$currentMonth-28";
        if (($paymentDate >= $newStartDateString) && ($paymentDate <= $newEndDateString)) {
            return true;
        } else {
            return false;
        }
    }

    $paymentDate = date('Y-m-d');
    $paymentDate = date('Y-m-d', strtotime($paymentDate));
    //echo $paymentDate; // echos today! 
    $contractDateBegin = date('Y-m-d', strtotime($cutoff->startDate));
    $contractDateEnd = date('Y-m-d', strtotime($cutoff->endDate));

    if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
        return true;
    } else {
        $currentMonth = date('m');
        $currentYear = date('Y');
        $currentDateStart = date('d', strtotime($cutoff->startDate));
        $currentDateEnd = date('d', strtotime($cutoff->endDate));

        $newStartDateString = "$currentYear-$currentMonth-$currentDateStart";
        $newEndDateString = "$currentYear-$currentMonth-$currentDateEnd";

        if (($paymentDate >= $newStartDateString) && ($paymentDate <= $newEndDateString)) {
            return true;
        } else {
            return false;
        }
    }
}


function format_date($data)
{
    return date_format($data, "Y/m/d H:i");
}


function format_status($data)
{
    if ($data == 'order') {
        return 'Menunggu diproses';
    } else if ($data == 'kirim') {
        return 'Barang Sedang Dikirim';
    } else if ($data == 'proses') {
        return 'Menunggu Pengiriman';
    } else if ($data == 'tolak') {
        return 'PO Ditolak';
    } else if ($data == 'selesai') {
        return 'PO Selesai';
    } else {
        return 'Check Status';
    }
}


function get_total_cart()
{
    $cart_products = collect(request()->session()->get('cart'));
    return count($cart_products);
}

function random_color()
{
    mt_srand((float)microtime() * 1000000);
    $c = '';
    while (strlen($c) < 6) {
        $c .= sprintf("%02X", mt_rand(0, 255));
    }
    $A = '#';
    return $A . $c;
}
