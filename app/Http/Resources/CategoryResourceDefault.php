<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResourceDefault extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'user' => $this->user_id,
            'order' => $this->order,
            'children' => CategoryResourceDefault::collection($this->whenLoaded('children'))
            // 'children' => CategoryResourceDefault::collection($this->children)
        ];
    }
}
