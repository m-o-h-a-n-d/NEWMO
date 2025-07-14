<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('can:categories');
    }
    public function index(Request $request)
    {
        // استخدام القيمة من الـ session بدلاً من request query
        $query = session('search_query');

        $categories = Category::withCount('posts');

        if ($query) {
            $categories = Category::search($query); // Meilisearch
            // أو بدون Scout:
            // $categories = $categories->where('name', 'like', "%$query%");
        }

        $categories = $categories->get();

        return view('admin.categories.index', compact('categories', 'query'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            $request->validated();
            $name = strip_tags($request->name);
            $slug = Str::slug($request->name);

            Category::create([
                'name' => $name,
                'slug' => $slug,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
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
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        $slug = Str::slug($request->name);

        try {
            DB::beginTransaction();
            $category->update([
                'name' => $request->name,
                'slug' => $slug,
                'status' => $request->status,
            ]);
            DB::commit();

            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong while updating: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);



        $FirstName = explode(' ', $category->name)[0]; // To display the first name

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', "$FirstName Deleted Successfully");
    }



    public function BlockCategory($id)
    {
        $category = Category::findOrFail($id);
        $FirstName = explode(' ', $category->name)[0]; // To display the first name
        if ($category->status == 0) {
            // Category$category was Block And convert it to Active
            $category->update([
                'status' => '1',
            ]);
            return redirect()->route('admin.categories.index')->with('success', "$FirstName Active Successfully");
        }
        // Category$category was Active And convert it to Block
        $category->update([
            'status' => '0',
        ]);


        return redirect()->route('admin.categories.index')->with('warning', "$FirstName Blocked Now!");
    }
}
