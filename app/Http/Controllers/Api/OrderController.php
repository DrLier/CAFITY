<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getLatestOrder()
    {
        $order = Order::where('done_at', null)
            ->with('orderProducts.product')
            ->latest()
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

        $orderDetails = [
            'order_code' => $order->invoice_number,
            'total_price' => $order->total_price,
            'paid_amount' => $order->paid_amount,
            'products' => $order->orderProducts->map(function ($orderProduct) {
                return [
                    'product_name' => $orderProduct->product->name,
                    'quantity' => $orderProduct->quantity,
                    'unit_price' => $orderProduct->unit_price,
                    'total_price' => $orderProduct->quantity * $orderProduct->unit_price,
                ];
            })
        ];

        return response()->json($orderDetails);
    }
}
