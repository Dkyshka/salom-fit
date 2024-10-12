<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Request $request, $product_id = null, $user_id = null)
    {
        $order = null;
        $product = Product::findOrFail($product_id);
        $user = User::findOrFail($user_id);

        if ($product && $user) {
            // Проверяем, существует ли уже заказ для данного пользователя и плана
            $order = Order::where('product_id', $product_id)
                ->where('user_id', $user_id)
                ->where('status', 1)
                ->first();

            if (!$order) {
                // Если заказа нет, создаем новый
                $order = new Order();
                $order->product_id = $product_id;
                $order->user_id = $user_id;
                $order->price = $product->price;
                $order->save();
            }
        }

        return view('web.orders.create', compact('order', 'user'));
    }
}
