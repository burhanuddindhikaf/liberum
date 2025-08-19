<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThreadResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'body'  => $this->body,
            "status" => $this->status,
            
            'author'=> [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'profile_photo_url' => $this->user->profile_photo_url
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name
            ],
            'media' => MediaResource::collection($this->whenLoaded('media')), // pasatikan relation 'media' sudah di-load

            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
