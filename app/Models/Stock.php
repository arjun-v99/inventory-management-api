<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Warehouse;

class Stock extends Model
{
    protected $table = 'stock';

    protected $fillable = [
        'warehouse_id',
        'product_id',
        'quantity',
        'expires_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
