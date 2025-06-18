<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
     public function index(Request $request)
    {
        $search = $request->input('search');

        $transactions = DB::table('transactions')
            ->leftJoin('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.username')
            ->when($search, function ($query, $search) {
                return $query->where('users.username', 'like', '%' . $search . '%');
            })
            ->orderByDesc('transactions.created_at')
            ->get();

        return view('dashboard.pages.transactions.index', compact('transactions', 'search'));
    }

    public function approve($id)
    {
        DB::table('transactions')->where('id', $id)->update([
            'status' => 'approved',
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.transactions.index')->with('success', 'Pesanan disetujui.');
    }

    public function reject($id)
    {
        DB::table('transactions')->where('id', $id)->update([
            'status' => 'rejected',
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.transactions.index')->with('success', 'Pesanan ditolak.');
    }

    public function destroy($id)
    {
        DB::table('transactions')->where('id', $id)->delete();

        return redirect()->route('admin.transactions.index')->with('success', 'Pesanan dihapus.');
    }
}
