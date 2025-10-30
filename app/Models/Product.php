<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_price'
    ];

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'stock')
            ->withPivot('quantity', 'expires_at')
            ->withTimestamps();
    }
}
