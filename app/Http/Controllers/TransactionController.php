<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $transactions = DB::table('transactions')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();
        return view('pages.transactions.index', compact('transactions'));
    }

    public function cancel($id)
    {
        $userId = Auth::id();
        $transaction = DB::table('transactions')->where('id', $id)->where('user_id', $userId)->first();

        if (!$transaction || $transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi tidak ditemukan atau tidak bisa dibatalkan.');
        }

        DB::beginTransaction();
        try {
            // Kembalikan stok barang
            $details = DB::table('transaction_details')->where('transaction_id', $id)->get();
            foreach ($details as $detail) {
                DB::table('medical_devices')->where('id', $detail->medical_device_id)
                    ->increment('quantity', $detail->quantity);
            }

            // Update status transaksi
            DB::table('transactions')->where('id', $id)->update([
                'status' => 'cancelled',
                'updated_at' => now()
            ]);

            DB::commit();
            return back()->with('success', 'Transaksi berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membatalkan transaksi.');
        }
    }
}
