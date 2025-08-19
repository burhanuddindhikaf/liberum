<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'body'  => $this->body,
            'author'=> $this->author ? [
                'id' => $this->author->id,
                'name' => $this->author->name
            ] : null,
            'media' => MediaResource::collection($this->whenLoaded('media')), // pastikan relation 'amedia' sudah di-load

            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}