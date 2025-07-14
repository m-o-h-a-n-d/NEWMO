<?php

namespace App\Http\Controllers\Admin\Autharizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Autharization\AutharizeRequest;
use App\Models\Autharization;
use Illuminate\Http\Request;

class AutharizeConroller extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
            $this->middleware('can:authorizations');
    }

    public function index()
    {
        $authorizations = Autharization::get();

        return view('admin.autharizations.index', compact('authorizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.autharizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AutharizeRequest $request)
    {
        $request->validated();
        // instance of Autharization model
        $autharize = new Autharization();
        //  fill the request data to the model
        $autharize->role = $request->role;
        //  convert the array to json string

        $autharize->permissions = $request->permissions;
        $autharize->save();
        return redirect()->route('admin.authorize.index')->with('success', 'Authorization created successfully');
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
        $authorize = Autharization::findOrFail($id);
        return view('admin.autharizations.edit', compact('authorize'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AutharizeRequest $request, string $id)
    {
        $request->validated();
        $autharize = Autharization::findOrFail($id);
        $autharize->role = $request->role;
        $autharize->permissions = $request->permissions;
        $autharize->save();
        return redirect()->route('admin.authorize.index')->with('success', 'Authorization updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Autharization::findOrFail($id);
        if ($role->admins->count() > 0) {
            return redirect()->back()->with('error', 'Authorization can not delete because it has relation with admin, Delete Relation First! ');
        }
        $role->delete();
        return redirect()->back()->with('success', 'Authorization deleted successfully');
    }
}
