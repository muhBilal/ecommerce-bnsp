<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreRequestController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->where('role', 'user')
            ->get();

        return view('dashboard.pages.store_requests.index', compact('users'));
    }

    public function approve($id)
    {
        DB::table('users')->where('id', $id)->update([
            'isStore' => 1,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.store_requests.index')->with('success', 'Pengajuan toko disetujui.');
    }

    public function reject($id)
    {
        DB::table('users')->where('id', $id)->update([
            'isStore' => 0,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.store_requests.index')->with('success', 'Pengajuan toko ditolak.');
    }
}
