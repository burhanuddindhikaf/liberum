<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'filename' => $this->filename,
            'original_filename' => $this->original_filename,
            'url' => $this->url,               // Ini accessor getUrlAttributea
            'thumbnail_url' => $this->thumbnail_url, // Ini accessor getThumbnailUrlAttribute
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'formatted_size' => $this->formatted_size,
        ];
    }
}
