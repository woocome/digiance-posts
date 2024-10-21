<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'external_post_id' => (int) $this->external_post_id,
            'title' => $this->title,
            'body' => $this->body,
            'user_id' => (int) $this->user_id,
        ];
    }
}
