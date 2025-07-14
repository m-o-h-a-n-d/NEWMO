<?php

namespace App\Http\Controllers\Admin\AdminManege;

use App\Models\Admin;
use App\Utils\ImageManger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admins\AdminRequest;
use App\Models\Autharization;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('can:admins');
    }
    public function index(Request $request)
    {
        // استرجاع قيمة البحث من السيشن بدل من الـ query string
        $query = session('search_query');

        $admins = Admin::where('id', '!=', Auth::guard('admin')->user()->id);

        if ($query) {
            $admins = Admin::search($query); // Meilisearch
            // بدون Scout:
            // $admins->where('name', 'like', "%$query%");
        }

        $admins = $admins->get();

        return view('admin.admins.index', compact('admins', 'query'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authorize = Autharization::select('id', 'role')->get();

        return view('admin.admins.create', compact('authorize'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {

        try {
            DB::beginTransaction();
            $request->validated();
            $admin = Admin::create($request->except(['_token', 'image', 'password_confirmation']));

            ImageManger::UploadingUserImage($admin); // this function is in Backend level
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack(); // rollback the transaction
            return redirect()->back()->with('error', 'The image is not uploaded');
        }

        return redirect()->back()->with('success', 'The Admin is created ');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);
        $authorization = Autharization::select('id', 'role')->get(); // أو Autharization لو ده اسم الموديل الحقيقي

        return view('admin.admins.show', compact('admin', 'authorization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, string $id)
    {
        $admin = Admin::findOrFail($id);
        $request->validated();
        $admin->update($request->except(['_token', 'image', 'password_confirmation'])); // this function is in Backend level
        ImageManger::UploadingUserImage($admin); // this function is in Backend level
        return redirect()->back()->with('success', 'Admin is updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $admin = Admin::findOrFail($id);
        ImageManger::deleteImageFromLocal($admin->image); // this function is in Backend level

        $admin->delete();
        return redirect()->back()->with('success', 'Admin is deleted');
    }

    public function BlockAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $firstName = explode(' ', $admin->name)[0];
        if ($admin->status == 0) {
            $admin->update([
                'status' => 1,
            ]);
            return redirect()->back()->with('success', 'Admin ' . $firstName . ' is unblock successfully');
        } else {
            $admin->update([
                'status' => 0,
            ]);
            return redirect()->back()->with('warning', 'Admin ' . $firstName . ' is block successfully');
        }
    }
}
