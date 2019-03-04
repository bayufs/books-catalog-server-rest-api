<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BooksByCategoryResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'link'     => $this->link,
            'image'    => $this->image,
            'author'   => $this->author,
            'category' => $this->category->name,
            'description' => $this->description,
            'redirect' => [
                'href'   => route('books.detail', ['id' => $this->id]),
                'method' => 'GET'
            ]
        ];
    }
}
