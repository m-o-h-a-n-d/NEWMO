<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = session('search_query');


        if ($query) {
            // استخدام Meilisearch
            $contacts = Contact::search($query)->paginate(10);
        } else {
            // عرض كل النتائج عادي
            $contacts = Contact::latest()->get();
        }

        return view('admin.contacts.index', compact('contacts', 'query'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
    public function show(string $id, Request $request)
    {
        // ✅ لو فيه إشعار مرتبط بالرابط ده
        if ($request->has('notify_admin')) {
            auth()->guard('admin')->user()
                ->notifications()
                ->where('id', $request->notify_admin)
                ->delete(); // أو ->first()?->markAsRead() لو مش عايز تمسحه
        }

        // ✅ جبنا الكونتاكت وحدثنا الحالة
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => 1]);

        return view('admin.contacts.show', compact('contact'));
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
    public function destroy(string $id)
    {


        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact and related notifications deleted');
    }
}
