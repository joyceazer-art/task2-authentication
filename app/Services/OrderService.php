<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Stock;
use App\Mail\LowStockAlert;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(array $data)
    {
        return DB::transaction(function () use ($data) {

            $order = new Order();
            $order->save();

            foreach ($data['items'] as $item) {

                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item['product_id'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->save();

                $product = Product::find($item['product_id']);

                foreach ($product->ingredients as $ingredient) {

                    $stock = Stock::where(
                        'product_id',
                        $ingredient->ingredient_id
                    )->first();

                    $requiredQuantity =
                        $ingredient->quantity * $item['quantity'];

                    $ingredientProduct =
                        Product::find($ingredient->ingredient_id);

                    if ($stock->quantity < $requiredQuantity) {
                        throw new \Exception(
                            'Not enough stock for ' . $ingredientProduct->name
                        );
                    }

                    $stock->quantity -= $requiredQuantity;
                    $stock->save();

                    if (
                        $stock->quantity <= ($stock->initial_quantity * 0.5)
                        && !$stock->low_stock_alert_sent
                    ) {
                        Mail::to('joyceazer@gmail.com')->send(
                            new LowStockAlert(
                                $ingredientProduct,
                                $stock->quantity
                            )
                        );

                        $stock->low_stock_alert_sent = true;
                        $stock->save();
                    }
                }
            }

            return $order;
        });
    }
}