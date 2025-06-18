<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceAdminController extends Controller
{

    public function index()
    {
        $devices = DB::table('medical_devices')
            ->join('device_types', 'medical_devices.type', '=', 'device_types.id')
            ->select('medical_devices.*', 'device_types.name as type_name')
            ->get();
        $types = DB::table('device_types')->get();
        return view('dashboard.pages.devices.index', compact('devices', 'types'));
    }

    public function create()
    {
        $types = DB::table('device_types')->get();
        return view('admin.devices.create', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('devices', 'public');
        }
        $data['created_at'] = now();
        $data['updated_at'] = now();
        DB::table('medical_devices')->insert($data);
        return redirect()->route('admin.devices.index')->with('success', 'Device added');
    }

    public function edit($id)
    {
        $device = DB::table('medical_devices')->where('id', $id)->first();
        $types = DB::table('device_types')->get();
        return view('admin.devices.edit', compact('device', 'types'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('devices', 'public');
        }
        $data['updated_at'] = now();
        DB::table('medical_devices')->where('id', $id)->update($data);
        return redirect()->route('admin.devices.index')->with('success', 'Device updated');
    }

    public function destroy($id)
    {
        DB::table('medical_devices')->where('id', $id)->delete();
        return redirect()->route('admin.devices.index')->with('success', 'Device deleted');
    }
}
