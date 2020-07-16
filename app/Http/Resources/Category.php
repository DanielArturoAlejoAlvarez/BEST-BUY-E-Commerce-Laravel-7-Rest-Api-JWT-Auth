<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use App\Product;
use App\Http\Resources\Product as ProductResource;

class Category extends JsonResource
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

        return [
          'id'        =>  $this->id,
          'name'      =>  $name,
          'products'  =>  ProductResource::collection($this->products),
          'published' =>  $this->created_at->diffForHumans(),
          'created_at'=>  $this->created_at->format('d-m-Y'),
          'updated_at'=>  $this->updated_at->format('d-m-Y')
        ];

        //return parent::toArray($request);
    }
}
