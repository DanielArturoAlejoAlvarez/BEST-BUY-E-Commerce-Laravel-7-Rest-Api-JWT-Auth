<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Image;

class Product extends Model
{

  protected $fillable = [
    'category_id',
    'code',
    'name',
    'excerpt',
    'body',
    'price',
    'stock'
  ];


  public function order_items() {
    return $this->hasMany(OrderItem::class);
  }

  public function orders() {
    return $this->belongsToMany(Order::class, "order_items");
  }

  public function category() {
    return $this->belongsTo(Category::class);
  }

  public function image() {
    return $this->morphOne(Image::class, 'imageable');
  }
}
