<?php

namespace App\Http\Controllers\Me;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagResourceBase;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(Request $request)
    {
        if($query = $request->query('search', false)){
            return TagResourceBase::collection(
                $request->user()->tags()->where("name","LIKE","%{$query}%")->limit(15)->get()
            );
        }
        return TagResourceBase::collection(
            $request->user()->tags
        );
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $category = $request->user()->tags()->create(
            $request->only('name')
        );

        return new TagResourceBase($category);
    }

    public function show(Tag $tag, Request $request)
    {
        return TagResourceBase::collection(
            $request->user()->tags()->get()
        );
    }

    public function update(Tag $tag, Request $request)
    {
        $this->authorize('update', $tag);

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $tag->update( $request->only('name') );
    }

    public function destroy(Tag $tag, Request $request)
    {
        $this->authorize('destroy', $tag);

        // dd($tag, $request->user());
        $tag->delete();
    }

    public function link(Tag $tag, Post $post, Request $request)
    {
        $this->authorize('update', $tag);

        $tag->posts()->syncWithoutDetaching([$post->id]);
        $tag->save();
    }

    public function unlink(Tag $tag, Post $post, Request $request)
    {
        $this->authorize('update', $tag);

        $tag->posts()->detach($post);
        $tag->save();
    }
}
