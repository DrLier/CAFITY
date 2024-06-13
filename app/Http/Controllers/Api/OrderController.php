<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrderByCode($orderCode)
    {
        $order = Order::where('invoice_number', $orderCode)
            ->with('orderProducts.product')
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    public function getOrderDetails($orderCode)
    {
        $order = Order::where('invoice_number', $orderCode)
            ->with('orderProducts.product')
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }
}
