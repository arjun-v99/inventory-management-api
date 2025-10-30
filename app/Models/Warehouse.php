<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'warehouse';

    protected $fillable = [
        'name',
        'location',
        'latitude',
        'longitude'
    ];

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'stock')
            ->withPivot('quantity', 'expires_at')
            ->withTimestamps();
    }
}
