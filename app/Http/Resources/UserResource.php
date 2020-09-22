<?php

namespace App\Http\Resources;

use App\Http\Resources\MediaResourceBase;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'verified' => $this->email_verified_at !== null,
            'username' => $this->username,
            'slug' => $this->slug,
            'avatar' => new MediaResourceBase($this->avatar()),
            // 'media' => MediaResourceBase::collection($this->medias())
        ];
    }
}
