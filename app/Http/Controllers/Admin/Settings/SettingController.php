<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\Settings\SettingRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function __construct()
    {
        $this->middleware('can:settings');
    }
    public function index()
    {

        return view('admin.settings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingRequest $request, string $id)
    {
        $validated = $request->validated();
        $setting = Setting::findOrFail($id);

        $data = $validated;

        // حذف اللوجو القديم لو موجود ورفع الجديد
        if ($request->hasFile('logo')) {
            if ($setting->logo && File::exists(public_path($setting->logo))) {
                File::delete(public_path($setting->logo)); // حذف القديم
            }

            $logo = $request->file('logo');
            $logoName = time() . '_' . Str::uuid() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/settings'), $logoName);
            $data['logo'] = 'uploads/settings/' . $logoName;
        }

        // حذف الفاف آيكون القديم لو موجود ورفع الجديد
        if ($request->hasFile('favicon')) {
            if ($setting->favicon && File::exists(public_path($setting->favicon))) {
                File::delete(public_path($setting->favicon)); // حذف القديم
            }

            $favicon = $request->file('favicon');
            $faviconName = time() . '_' . Str::uuid() . '.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('uploads/settings'), $faviconName);
            $data['favicon'] = 'uploads/settings/' . $faviconName;
        }

        $success = $setting->update($data);

        if (!$success) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
