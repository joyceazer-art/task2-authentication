<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function stocks()
{
    return $this->hasMany(Stock::class);
}
public function stockTransfers()
{
    return $this->hasMany(StockTransfer::class);
}
public function ingredients()
{
    return $this->hasMany(ProductIngredient::class);
}

public function usedAsIngredient()
{
    return $this->hasMany(ProductIngredient::class, 'ingredient_id');
}
public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

}
