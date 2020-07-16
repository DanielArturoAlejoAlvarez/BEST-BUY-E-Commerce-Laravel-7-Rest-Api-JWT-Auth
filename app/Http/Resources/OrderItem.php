<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class OrderItem extends JsonResource
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
        'id'          =>    $this->id,
        'order_id'    =>    $this->order_id,
        'product_id'  =>    $this->product_id,
        'price'       =>    $this->price,
        'quantity'    =>    $this->quantity,
        'subtotal'    =>    round($this->price*$this->quantity,2),
        'published'   =>    $this->created_at->diffForHumans(),
        'created_at'  =>    $this->created_at->format('d-m-Y'),
        'updated_at'  =>    $this->updated_at->format('d-m-Y')
      ];
        //return parent::toArray($request);
    }
}
