<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\Product as ProductResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {



      return [
        'id'        =>  $this->id,
        'name'      =>  $this->name,
        'email'     =>  $this->email,
        'password'  =>  $this->password,
        'avatar'    =>  $this->image->url,
        'orders_count' => $this->orders->count(),
        'orders'       => OrderResource::collection($this->orders),
        'published' =>  $this->created_at->diffForHumans(),
        'created_at'=>  $this->created_at->format('d-m-Y'),
        'updated_at'=>  $this->updated_at->format('d-m-Y')
      ];

        //return parent::toArray($request);
    }
}
