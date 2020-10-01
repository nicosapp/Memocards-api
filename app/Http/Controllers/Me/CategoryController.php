<?php

namespace App\Http\Controllers\Me;


use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceBase;
use App\Http\Resources\Me\CategoryTreeResource;

class CategoryController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api']);
  }

  public function index(Request $request)
  {
    if ($query = $request->query('search', false)) {
      return CategoryResourceBase::collection(
        $request->user()->categories()->where("name", "LIKE", "%{$query}%")->limit(15)->get()
      );
    }
    // $categories = Category::parents()->ordered()->get();
    return CategoryTreeResource::collection(
      $request->user()->categories()->parents()->ordered()->get()
      // Category::with('children', 'children.children')->parents()->ordered()->get()
    );
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:255',
      'order' => 'nullable',
    ]);

    $category = $request->user()->categories()->create(
      $request->only('name', 'order')
    );

    return new CategoryTreeResource($category);
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
    $this->authorize('update', $category);

    $this->validate($request, [
      'name' => 'required|max:255',
      'order' => 'integer|nullable',
      'parent_id' => 'integer|nullable'
    ]);

    $category->update(
      $request->only('name', 'order', 'parent_id')
    );
  }

  public function updateBulk(Request $request)
  {
    $categories = $request->input('categories');
    // dd($categories);
    $this->validate($request, [
      'categories.*.name' => 'required|max:255',
      'categories.*.order' => 'integer|nullable',
      'categories.*.parent_id' => 'integer|nullable'
    ]);

    foreach ($categories as $d) {
      extract($d);
      $category = Category::where('id', $id);

      $this->authorize('update', $category->first());

      $category->update([
        'order' => $order,
        'parent_id' => $parent_id,
        'name' => $name
      ]);
    }
  }

  public function link(Category $category, Post $post, Request $request)
  {
    $this->authorize('update', $category);

    $category->posts()->syncWithoutDetaching([$post->id]);
    $category->save();
  }

  public function unlink(Category $category, Post $post, Request $request)
  {
    $this->authorize('update', $category);

    $category->posts()->detach($post);
    $category->save();
  }

  public function destroy(Category $category, Request $request)
  {
    $this->authorize('destroy', $category);

    $category->delete();
  }
}
