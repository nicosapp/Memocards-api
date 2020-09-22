<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResourceBase extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function hasThumbnail($model){
        try{
            return $this->getUrl('thumb');
        } catch(Exception $e) {
            return null;
        }
    }
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->getFullUrl(),
            'thumbnail_url' => $this->hasThumbnail($this)
        ];
    }
}
