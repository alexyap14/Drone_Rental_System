<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = DB::table('checkout')
            ->where('user_id', $user->id)
            ->orderBy('order_group_id', 'desc')
            ->get()
            ->groupBy('order_group_id');

        return view('purchase-history.index', compact('orders'));
    }
}