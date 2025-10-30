<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Services\DynamicPricingService;

class ProductController extends Controller
{
    // product can have multiple stock entries
    public function getProducts(Request $request, DynamicPricingService $pricingService)
    {
        try {
            $products = Product::with('stock.warehouse')->get();

            $result = $products->map(function ($product) use ($pricingService) {
                return $this->formatProduct($product, $pricingService);
            });

            return response()->json($result);
        } catch (Exception $e) {
            Log::error('Unable to fetch products. Error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    /**
     * Format a single product and attach its stock info.
     */
    private function formatProduct(Product $product, DynamicPricingService $pricingService): array
    {
        return [
            'product_id' => $product->id,
            'name' => $product->name,
            'base_price' => $product->base_price,
            'stock' => $this->formatStockList($product->stock, $pricingService),
        ];
    }

    /**
     * Format all stock items for a product.
     */
    private function formatStockList($stocks, DynamicPricingService $pricingService): array
    {
        return $stocks->map(fn($stock) => $this->formatStock($stock, $pricingService))->toArray();
    }

    /**
     * Format a single stock record with dynamic pricing.
     */
    private function formatStock($stock, DynamicPricingService $pricingService): array
    {
        return [
            'warehouse' => [
                'id' => $stock->warehouse->id,
                'latitude' => $stock->warehouse->latitude,
                'longitude' => $stock->warehouse->longitude,
            ],
            'quantity' => $stock->quantity,
            'expires_at' => $stock->expires_at,
            'dynamic_price' => $pricingService->calculate($stock),
        ];
    }
}
