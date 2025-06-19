<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = DB::table('users')
            ->where('role', 'user')
            ->count();
        $totalTransactions = DB::table('transactions')
            ->count();;
        $totalProducts = DB::table('medical_devices')
            ->count();;

        return view('dashboard.index', compact('totalUsers', 'totalTransactions', 'totalProducts'));
    }
}
