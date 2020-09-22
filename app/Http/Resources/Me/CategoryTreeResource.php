<?php

namespace App\Http\Resources\Me;

use App\Http\Resources\CategoryResourceBase;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTreeResource extends CategoryResourceBase
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
            'children'=>CategoryTreeResource::collection($this->children)
        ]);
    }
}
