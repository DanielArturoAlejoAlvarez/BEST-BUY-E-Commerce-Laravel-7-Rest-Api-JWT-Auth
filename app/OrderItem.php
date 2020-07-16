<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

  protected $fillable = [
    'order_id',
    'product_id',
    'quantity',
    'price'
  ];

  public function product() {
    return $this->belongsTo(Product::class);
  }

  public function order() {
    return $this->belongsTo(Order::class);
  }
}
