<?php

namespace App\Http\Resources\Me;

use App\Http\Resources\PostResourceDefault;
use App\Http\Resources\CategoryResourceDefault;
use App\Http\Resources\TagResourceDefault;

class PostResource extends PostResourceDefault
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'owner' => $this->user_id === auth()->user()->id,
            'categories' => CategoryResourceDefault::collection($this->categories),
            'tags' => TagResourceDefault::collection($this->tags),
        ]);
    }
}
