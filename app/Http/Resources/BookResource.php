<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            'id' => $this->id,
            'name' => $this->book_name,
            'author' => $this->author,
            'published_date' => $this->published_date,
            'book_image' => $this->book_image,
            'genres' => $this->genres,
            'rating' => $this->rating,

        ];
    }
}
