<?php

namespace App\Http\Resources\Me;

use App\Http\Resources\PostResourceBase;
use App\Http\Resources\CategoryResourceBase;
use App\Http\Resources\TagResourceBase;

class PostResource extends PostResourceBase
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
            'categories' => CategoryResourceBase::collection($this->categories),
            'tags' => TagResourceBase::collection($this->tags),
        ]);
    }
}
