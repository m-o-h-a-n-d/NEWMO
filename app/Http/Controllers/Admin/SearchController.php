<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Contact;

class SearchController extends Controller
{

    public function search(Request $request, $table)
    {
        $query = $request->input('q');
        $results = [];

        if (!$table) {
            return back()->with('error', 'يرجى اختيار جدول للبحث.');
        }

        switch ($table) {
            case 'posts':
                if (auth()->guard('admin')->user()->can('posts')) {
                    $results['posts'] = Post::search($query)->get();
                }
                break;

            case 'users':
                if (auth()->guard('admin')->user()->can('users')) {
                    $results['users'] = User::search($query)->get();
                }
                break;

            case 'categories':
                if (auth()->guard('admin')->user()->can('categories')) {
                    $results['categories'] = Category::search($query)->get();
                }
                break;

            case 'contacts':
                if (auth()->guard('admin')->user()->can('contacts')) {
                    $results['contacts'] = Contact::search($query)->get();
                }
                break;

            case 'admins':
                if (auth()->guard('admin')->user()->can('admins')) {
                    $results['admins'] = Admin::search($query)->get();
                }
                break;

            default:
                return back()->with('error', 'please select a table to search');
        }

        return view('admin.search.index', compact('results', 'query', 'table'));
    }

    public function redirectToSearchTable(Request $request)
    {
        $query = $request->input('q');
        $table = $request->input('table');

        if (!$table) {
            return back()->with('error', 'Please select a table to search');
        }

        // حفظ الكلمة مؤقتًا في السيشن بدل ما تظهر في الرابط
        session()->flash('search_query', $query);

        return redirect()->route("admin.$table.index");
    }

    
}
