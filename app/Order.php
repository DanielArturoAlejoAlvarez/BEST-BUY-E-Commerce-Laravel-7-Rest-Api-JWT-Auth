<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

  protected $fillable = [
    'user_id'
  ];

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function order_items() {
    return $this->hasMany(OrderItem::class);
  }

  public function products() {
    return $this->belongsToMany(Product::class, "order_items");
  }
}
