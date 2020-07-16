<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\OrderItem;
use Illuminate\Http\Request;

use App\Http\Resources\OrderItemCollection;
use App\Http\Resources\OrderItem as OrderItemResource;

class OrderItemController extends Controller
{
    private $orderItem;
    function __construct(OrderItem $orderItem)
    {
      $this->orderItem = $orderItem;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderItems = $this->orderItem->orderBy('id','desc')->get();
        return response()->json(new OrderItemCollection($orderItems));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $orderItem)
    {
        return response()->json(new OrderItemResource($orderItem));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
