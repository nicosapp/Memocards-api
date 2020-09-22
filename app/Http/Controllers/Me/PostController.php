<?php

namespace App\Http\Controllers\Me;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Scoping\Scopes\TagScope;
use App\Http\Controllers\Controller;
use App\Scoping\Scopes\CategoryScope;
use App\Http\Resources\Me\PostResource;
use App\Http\Resources\PostResourceBase;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }
    
    public function index(Request $request)
    {    
        if($query = $request->query('search', false)){
            return PostResource::collection(
                $request->user()->posts()->where("post_title","LIKE","%{$query}%")
                    ->orWhere("post_content", "LIKE", "%{$query}%")->ordered()->paginate(3)
            );
        }

        return PostResource::collection(
            $request->user()->posts()->withScopes($this->scopes())->paginate(3)
        );
    }

    public function show(Post $post)
    {
        $this->authorize('show', $post);

        return new PostResource($post);
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

        return new PostResource($post);
    }

    /**
     * Undocumented function
     *
     * @param Post $post
     * @param Request $request
     * @return void
     */
    public function update(Post $post, Request $request)
    {
        $this->authorize('update', $post);

        $this->validate($request, [
            'post_title' => 'nullable',
            'post_content' => 'nullable'
        ]);

        $post->update($request->only('post_title', 'post_content'));
    }

    /**
     * Undocumented function
     *
     * @param Post $post
     * @param Request $request
     * @return void
     */
    public function destroy(Post $post, Request $request){

        $this->authorize('destroy', $post);
        
        $post->delete();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function scopes()
    {
        return [
            'category' => new CategoryScope(),
            'tag' => new TagScope(),
        ];
    }
}
