<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\Order as OrderResource;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    private $order;

    function __construct(Order $order)
    {
      $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->order->orderBy('id','desc')->get();
        return response()->json(new OrderCollection($orders));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
      $order = $this->order->create($request->all());
      foreach ($request->order_items as $item) {
         $product = Product::find($item['product_id']);
         $order->order_items()->create([
           "product_id" =>  $product->id,
           'quantity'   =>  $item['quantity'],
           'price'      =>  $product->price
         ]);
         $currentStock = $product->stock - $item['quantity'];
         $product->update(['stock' => $currentStock]);
       }
      return response()->json(new OrderResource($order));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return response()->json(new OrderResource($order));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
      $order->update($request->all());
      foreach ($request->order_items as $key => $item) {
         $product = Product::find($item['product_id']);
         $order->order_items[$key]->update([
           "product_id" =>  $product->id,
           'quantity'   =>  $item['quantity'],
           'price'      =>  $product->price
         ]);
         $currentStock = $product->stock - $item['quantity'];
         $product->update(['stock' => $currentStock]);
       }
      return response()->json(new OrderResource($order));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }


}
