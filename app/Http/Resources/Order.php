<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Product;
use App\OrderItem;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\OrderItem as OrderItemResource;
use Illuminate\Support\Str;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        

        // $collection = Product::whereHas('order_items', function ($query) {
        //               return $query->where('order_id', '=', $this->id);
        //             })->get();


        $total = 0;
        foreach ($this->order_items as $item) {
          $total += $item->price*$item->quantity;
        }

        return [
          'id'                =>    $this->id,
          'user_id'           =>    $this->user_id,
          'products_count'    =>    $this->products->count(),
          'products_count'    =>    $this->products->count(),
          'order_items_count' =>    $this->order_items->count(),
          'payment'           =>    round($total, 2),
          'products'          =>    ProductResource::collection($this->products),
          'order_items'       =>    OrderItemResource::collection($this->order_items),
          'published'         =>    $this->created_at->diffForHumans(),
          'created_at'        =>    $this->created_at->format('d-m-Y'),
          'updated_at'        =>    $this->updated_at->format('d-m-Y')
        ];

        //return parent::toArray($request);
    }


}
