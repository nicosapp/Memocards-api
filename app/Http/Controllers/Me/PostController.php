<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Transformers\Posts\PostTransformer;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __contruct()
    {
        $this->middleware(['auth:api']);
    }
    
    public function index(Request $request)
    {
        return fractal()
            ->collection($request->user()->posts)
            ->transformWith(new PostTransformer())
            ->toArray();
    }
}
