<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;


class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $name = Str::upper($this->name);
        //$category = Str::upper($this->category->name);

        return [
          'id'          =>    $this->id,
          'category_id' =>    $this->category_id,
          'category'    =>    $this->category,
          'code'        =>    $this->code,
          'name'        =>    $name,
          'excerpt'     =>    $this->excerpt,
          'body'        =>    $this->body,
          'price'       =>    $this->price,
          'stock'       =>    $this->stock,
          'image'       =>    $this->image->url,
          'published'   =>    $this->created_at->diffForHumans(),
          'created_at'  =>    $this->created_at->format('d-m-Y'),
          'updated_at'  =>    $this->updated_at->format('d-m-Y')
        ];

        //return parent::toArray($request);
    }
}
