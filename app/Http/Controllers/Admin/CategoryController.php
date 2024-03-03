<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\EditCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['products', 'parent'])->sortable()->paginate(10);

        return view('admin/categories/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/categories/create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::of($data['name'])->slug()->value();

        Category::create($data);

        notify()->success("Category '$data[name]' was created!");

        return redirect()->route('admin.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();
        return view('admin/categories/edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['slug'] = Str::of($data['name'])->slug()->value();

        $category->updateOrFail($data);

        notify()->success("Category '$data[name]' was changed!");

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->middleware('permission:' . config('permission.permissions.categories.delete'));

        if ($category->children()->exists()) {
            $category->children()->update(['parent_id' => null]);
        }

        $category->deleteOrFail();

        notify()->success("Category '$category[name]' was deleted!");


        return redirect()->route('admin.categories.index');

    }
}
