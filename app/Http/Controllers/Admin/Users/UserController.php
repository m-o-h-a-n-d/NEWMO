<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\User;
use App\Utils\ImageManger;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('can:users');
    }

    public function index(Request $request)
    {
        $query = session('search_query');


        $users = User::query();

        if ($query) {
            $users = User::search($query); // Meilisearch
        }

        $users = $users->get();

        return view('admin.users.index', compact('users', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $request->validated();

        try {
            DB::beginTransaction();
            $request->merge([
                'email_verified_at' => $request->email_verified_at == 1 ? now() : null,
            ]);
            $user = User::create($request->except('_token', 'image', 'password_confirmation'));

            ImageManger::UploadingUserImage($user); // this function is in Backend level
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        return redirect()->back()->with('success', 'The User is created ');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);


        return view('admin.users.show', compact('user'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $user = User::findOrFail($id);

        ImageManger::deleteImageFromLocal($user->image);

        $FirstName = explode(' ', $user->name)[0]; // To display the first name

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', "$FirstName Deleted Successfully");
    }


    public function BlockUser($id)
    {
        $user = User::findOrFail($id);
        $FirstName = explode(' ', $user->name)[0]; // To display the first name
        if ($user->status == 0) {
            // USER was Block And convert it to Active
            $user->update([
                'status' => '1',
            ]);
            return redirect()->route('admin.users.index')->with('success', "$FirstName Active Successfully");
        }
        // USER was Active And convert it to Block
        $user->update([
            'status' => '0',
        ]);


        return redirect()->route('admin.users.index')->with('warning', "$FirstName Blocked Now!");
    }
}
