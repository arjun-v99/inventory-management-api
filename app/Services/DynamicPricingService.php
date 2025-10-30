<?php

namespace App\Services;

use App\Models\Stock;

class DynamicPricingService
{
    public function calculate(Stock $stock)
    {
        $price = $stock->product->base_price; // base price

        //Discount if near expiry
        if ($stock->expires_at) {
            $daysLeft = now()->diffInDays($stock->expires_at, false);

            if ($daysLeft <= 7) {
                $price *= 0.75; // 25% discount
            }
        }

        //Increase price if stock < 10
        if ($stock->quantity < 10) {
            $price *= 1.3; //by +30% 
        }

        //Increase price if stock > 10 and less than 50
        if ($stock->quantity > 10 && $stock->quantity < 50) {
            $price *= 1.3; //by +10% 
        }

        if ($stock->quantity > 100) {
            $price *= 0.8; //by -20% 
        }

        return round($price, 2);
    }
}
