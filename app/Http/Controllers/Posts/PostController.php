<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\Posts\PostTransformer;

class PostController extends Controller
{
    /**
     * Undocumented function
     */
    public function __construct()
    {   
        $this->middleware(['auth:api'])
            ->only('store', 'update', 'destroy');
    }

    public function index(Request $request)
    {
        return fractal()
            ->collection(
                Post::take($request->get('limit', 10))->latest()->public()->get()
            );
    }

    public function show(Post $post)
    {
        $this->authorize('show', $post);

        return fractal()
            ->item($post)
            ->transformWith(new PostTransformer())
            ->toArray();
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $post = $request->user()->posts()->create([
            'uuid'=>Str::uuid()
        ]);

        return fractal()
            ->item($post)
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    public function update(Post $post, Request $request)
    {
        $this->authorize('update', $post);

        $this->validate($request, [
            'post_title' => 'nullable',
            'post_content' => 'nullable'
        ]);

        $post->update($request->only('post_title', 'post_content'));
    }

    public function destroy(Post $post, Request $request){

        $this->authorize('destroy', $post);
        
        $post->delete();
    }
}
