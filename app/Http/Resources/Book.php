<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // return parent::toArray($request);

       return [
        'id'       => $this->id,
        'title'    => $this->title,
        'link'     => $this->link,
        'image'    => $this->image,
        'author'   => $this->author,
        'category' => $this->category->name,
        'description' => $this->description,
        'created_at' => $this->created_at,
        'featured' => $this->featured,
        'category_id' => $this->category_id,
        'redirect' => [
            'href'   => [
                'edit' => route('books.edit', ['id' => $this->id]),
                'delete' => route('books.delete', ['id' => $this->id]),
                'back' => route('books.all')
            ],

            'method' => [
                'DELETE', 'GET'
            ],
            
        ]
    ];
    }
}
