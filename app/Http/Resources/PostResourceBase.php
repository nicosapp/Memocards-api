<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResourceBase extends JsonResource
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
            'uuid' => $this->uuid,
            'post_title' => $this->post_title,
            'post_content' => $this->post_content,
            'post_excerpt' => $this->post_excerpt,
            'created_at' => $this->create_at,
            'updated_at' => $this->updated_at,
            'author' => new UserResource($this->user),
        ];
    }
}
