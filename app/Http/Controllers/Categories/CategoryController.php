<?php

namespace App\Http\Controllers\Categories;


use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceDefault;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index()
    {
        // $categories = Category::parents()->ordered()->get();
        return CategoryResourceDefault::collection(
            Category::parents()->ordered()->get()
            // Category::with('children', 'children.children')->parents()->ordered()->get()
        );
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'nullable',
            'order' => 'nullable'
        ]);

        $category = $request->user()->categories()->create(
            $request->only('name', 'order'));

        return new CategoryResourceDefault($category);
    }

    public function show(Category $category, Request $request)
    {
        // $category = $request->user()->posts()->create([
        //     'uuid'=>Str::uuid()
        // ]);

        // return fractal()
        //     ->item($post)
        //     ->transformWith(new PostTransformer())
        //     ->toArray();
    }

    public function update(Category $category, Request $request)
    {
        // $this->authorize('update', $category);

        $this->validate($request, [
            'name' => 'nullable',
            'order' => 'nullable',
            'parent_id' => 'integer'
        ]);

        $category->update($request->only('name', 'order','parent_id'));
    }

    public function destroy(Category $category, Request $request)
    {
        //$this->authorize('destroy', $category);

        $category->delete();
    }
}
