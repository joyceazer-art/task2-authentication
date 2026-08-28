<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\ProductIngredient;

class StockTransferSeeder extends Seeder
{
    public function run(): void
    {
        // Products
        $burger = new Product();
        $burger->name = 'Burger';
        $burger->sku = 'BURGER';
        $burger->price = 100;
        $burger->description = 'Classic Burger';
        $burger->save();

        $beef = new Product();
        $beef->name = 'Beef';
        $beef->sku = 'BEEF';
        $beef->price = 0;
        $beef->description = 'Beef ingredient';
        $beef->save();

        $cheese = new Product();
        $cheese->name = 'Cheese';
        $cheese->sku = 'CHEESE';
        $cheese->price = 0;
        $cheese->description = 'Cheese ingredient';
        $cheese->save();

        $onion = new Product();
        $onion->name = 'Onion';
        $onion->sku = 'ONION';
        $onion->price = 0;
        $onion->description = 'Onion ingredient';
        $onion->save();

        // Warehouse
        $warehouse = new Warehouse();
        $warehouse->name = 'Main Warehouse';
        $warehouse->location = 'Cairo';
        $warehouse->save();

        // Stock
        $beefStock = new Stock();
        $beefStock->product_id = $beef->id;
        $beefStock->warehouse_id = $warehouse->id;
        $beefStock->quantity = 20000;
        $beefStock->initial_quantity = 20000;
        $beefStock->low_stock_alert_sent = false;
        $beefStock->save();

        $cheeseStock = new Stock();
        $cheeseStock->product_id = $cheese->id;
        $cheeseStock->warehouse_id = $warehouse->id;
        $cheeseStock->quantity = 5000;
        $cheeseStock->initial_quantity = 5000;
        $cheeseStock->low_stock_alert_sent = false;
        $cheeseStock->save();

        $onionStock = new Stock();
        $onionStock->product_id = $onion->id;
        $onionStock->warehouse_id = $warehouse->id;
        $onionStock->quantity = 1000;
        $onionStock->initial_quantity = 1000;
        $onionStock->low_stock_alert_sent = false;
        $onionStock->save();

        // Burger ingredients
        $burgerBeef = new ProductIngredient();
        $burgerBeef->product_id = $burger->id;
        $burgerBeef->ingredient_id = $beef->id;
        $burgerBeef->quantity = 150;
        $burgerBeef->save();

        $burgerCheese = new ProductIngredient();
        $burgerCheese->product_id = $burger->id;
        $burgerCheese->ingredient_id = $cheese->id;
        $burgerCheese->quantity = 30;
        $burgerCheese->save();

        $burgerOnion = new ProductIngredient();
        $burgerOnion->product_id = $burger->id;
        $burgerOnion->ingredient_id = $onion->id;
        $burgerOnion->quantity = 20;
        $burgerOnion->save();
    }
}