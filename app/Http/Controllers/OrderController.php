<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'price' => 'required|numeric',
        ]);

        return Order::create($request->all());
    }

    public function show(Order $order)
    {
        return $order;
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'product_id' => 'sometimes|exists:products,id',
            'user_id' => 'sometimes|exists:users,id',
            'price' => 'sometimes|numeric',
        ]);

        $order->update($request->all());
        return $order;
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->noContent();
    }
}
