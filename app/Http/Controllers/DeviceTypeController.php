<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceTypeController extends Controller
{
    public function index()
    {
        $types = DB::table('device_types')->get();
        return view('dashboard.pages.device_types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:device_types,name',
        ]);

        DB::table('device_types')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.device-types.index')->with('success', 'Tipe alat berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:device_types,name,' . $id,
        ]);

        DB::table('device_types')->where('id', $id)->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.device-types.index')->with('success', 'Tipe alat berhasil diubah.');
    }

    public function destroy($id)
    {
        DB::table('device_types')->where('id', $id)->delete();

        return redirect()->route('admin.device-types.index')->with('success', 'Tipe alat berhasil dihapus.');
    }
}
