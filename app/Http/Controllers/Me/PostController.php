<?php

namespace App\Http\Controllers\Me;

use Illuminate\Http\Request;
use App\Scoping\Scopes\TagScope;
use App\Http\Controllers\Controller;
use App\Scoping\Scopes\CategoryScope;
use App\Http\Resources\Me\PostResource;
use App\Transformers\Posts\PostTransformer;

class PostController extends Controller
{
    public function __contruct()
    {
        $this->middleware(['auth:api']);
    }
    
    public function index(Request $request)
    {
        // $posts = Post::withScopes($this->scopes());

        // return PostResource::collection();
            // ->where('slug','child')->orWhere('slug','parent'))
            

        return PostResource::collection(
            $request->user()->posts()->withScopes($this->scopes())->get()
            // $request->user()->posts()->withScopes($this->scopes())->get()
        );
        // return fractal()
        //     ->collection($request->user()->posts()->withScopes($this->scopes()))
        //     ->transformWith(new PostTransformer())
        //     ->toArray();
    }

    public function scopes()
    {
        return [
            'category' => new CategoryScope(),
            'tag' => new TagScope(),
        ];
    }
}
