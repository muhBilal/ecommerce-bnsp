<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('medical_devices')
            ->leftJoin('device_types', 'medical_devices.type', '=', 'device_types.id')
            ->select('medical_devices.*', 'device_types.name as category_name');

        if ($request->filled('search')) {
            $query->where('medical_devices.name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('medical_devices.type', $request->category);
        }

        $products = $query->orderBy('medical_devices.created_at', 'desc')->paginate(8);

        $categories = DB::table('device_types')->get();

        return view('pages.product.index', compact('products', 'categories'));
    }
}
