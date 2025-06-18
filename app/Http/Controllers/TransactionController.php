<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
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
            $details = DB::table('transaction_details')->where('transaction_id', $id)->get();
            foreach ($details as $detail) {
                DB::table('medical_devices')->where('id', $detail->medical_device_id)
                    ->increment('quantity', $detail->quantity);
            }

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

    public function invoice($id)
    {
        $trx = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.username', 'users.address', 'users.phone_number')
            ->where('transactions.id', $id)
            ->first();

        if (!$trx) {
            abort(404);
        }

        $items = DB::table('transaction_details')
            ->join('medical_devices', 'transaction_details.medical_device_id', '=', 'medical_devices.id')
            ->where('transaction_details.transaction_id', $id)
            ->select(
                'medical_devices.name',
                'transaction_details.quantity',
                'transaction_details.price'
            )
            ->get();

        $data = [
            'store_name' => 'Toko Medika Sehat',
            'buyer_name' => $trx->username,
            'address' => $trx->address,
            'phone' => $trx->phone_number,
            'date' => \Carbon\Carbon::parse($trx->created_at)->format('d-m-Y'),
            'payment_method' => $trx->payment_method ?? '-',
            'items' => $items,
            'total_price' => $trx->total_price,
        ];

        $pdf = Pdf::loadView('invoices.invoice', $data);
        return $pdf->download('invoice_' . $trx->id . '.pdf');
    }
}
