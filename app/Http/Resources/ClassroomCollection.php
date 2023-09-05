<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClassroomCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
      /*   return [
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],
        ];
         */
        return [
            'id' => $this->id,
            'title' => $this->name,
            'code' => $this->code,
            'meta' => [
                'section' => $this->section,
                'room' => $this->room,
                'theme' => $this->theme, 
                'students_count' => $this->students_count ?? null,
            ],
            'user' => [
                'name' => $this->user->name ?? null,
            ]
        ];    }
}
