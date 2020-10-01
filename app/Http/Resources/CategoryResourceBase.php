<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResourceBase extends JsonResource
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
      'id' => $this->id,
      'name' => $this->name,
      'user_id' => $this->user_id,
      'order' => $this->order,
      'parent_id' => $this->parent_id,
      'posts_count' => $this->posts()->count(),
      'children' => CategoryResourceBase::collection($this->whenLoaded('children'))
      // 'children' => CategoryResourceBase::collection($this->children)
    ];
  }
}
