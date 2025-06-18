<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = DB::table('carts')
            ->join('medical_devices', 'carts.device_id', '=', 'medical_devices.id')
            ->where('carts.user_id', Auth::id())
            ->select('carts.*', 'medical_devices.name as device_name', 'medical_devices.price as price', 'medical_devices.image as device_image')
            ->get();
        return view('pages.cart.index', compact('cartItems'));
    }

    public function add(Request $request, $deviceId)
    {
        $existing = DB::table('carts')
            ->where('user_id', Auth::id())
            ->where('device_id', $deviceId)
            ->first();

        if ($existing) {
            DB::table('carts')->where('id', $existing->id)
                ->update(['quantity' => $existing->quantity + 1]);
        } else {
            DB::table('carts')->insert([
                'user_id' => Auth::id(),
                'device_id' => $deviceId,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['status' => 'added']);
    }

    public function remove($id)
    {
        DB::table('carts')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function increase($id)
    {
        $item = DB::table('carts')->where('id', $id)->where('user_id', Auth::id())->first();

        if ($item) {
            DB::table('carts')->where('id', $id)->increment('quantity');
        }

        return response()->json(['status' => 'success']);
    }

    public function decrease($id)
    {
        $item = DB::table('carts')->where('id', $id)->where('user_id', Auth::id())->first();

        if ($item && $item->quantity > 1) {
            DB::table('carts')->where('id', $id)->decrement('quantity');
        }

        return response()->json(['status' => 'success']);
    }

    public function checkout(Request $request)
    {
        $userId = Auth::id();
        $paymentMethod = $request->input('payment_method');

        $cartItems = DB::table('carts')
            ->where('user_id', $userId)
            ->join('medical_devices', 'carts.device_id', '=', 'medical_devices.id')
            ->select('carts.device_id', 'carts.quantity', 'medical_devices.price', 'medical_devices.quantity as stock')
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }
        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item->price * $item->quantity;
            }

            $transactionId = DB::table('transactions')->insertGetId([
                'user_id' => $userId,
                'total_price' => $total,
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($cartItems as $item) {
                DB::table('transaction_details')->insert([
                    'transaction_id' => $transactionId,
                    'medical_device_id' => $item->device_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('medical_devices')
                    ->where('id', $item->device_id)
                    ->decrement('quantity', $item->quantity);
            }

            DB::table('carts')->where('user_id', $userId)->delete();
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Checkout berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }
}
