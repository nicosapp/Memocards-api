<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResourceDefault extends JsonResource
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
            'post_title' => $this->post_title,
            'post_content' => $this->post_content,
            'created_at' => $this->create_at,
            'updated_at' => $this->updated_at,
            'author' => new UserResource($this->user),
        ];
    }
}
