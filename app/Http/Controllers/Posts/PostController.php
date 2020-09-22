<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResourceBase;

class PostController extends Controller
{
    /**
     * Undocumented function
     */
    public function __construct()
    {   
        $this->middleware(['auth:api']);
    }

    public function index(Request $request)
    {
        return PostResourceBase::collection(
            Post::take($request->get('limit', 10))->latest()->get()
        );
    }
}
