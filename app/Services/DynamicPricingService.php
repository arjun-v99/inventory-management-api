<?php

namespace App\Services;

use App\Models\Stock;

class DynamicPricingService
{
    public function calculate(Stock $stock)
    {
        $price = $stock->product->base_price; // base price

        // 1️⃣ Discount if near expiry
        if ($stock->expires_at) {
            $daysLeft = now()->diffInDays($stock->expires_at, false);

            if ($daysLeft <= 7) {
                $price *= 0.75; // 25% discount
            }
        }

        // 2️⃣ Increase if low stock
        if ($stock->quantity < 10) {
            $price *= 1.3; // +30% 
        }

        if ($stock->quantity > 10 && $stock->quantity < 50) {
            $price *= 1.3; // +10% 
        }

        if ($stock->quantity > 100) {
            $price *= 0.8; // -20% 
        }

        return round($price, 2);
    }
}
