<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockRequest;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;

class StockController extends Controller
{
    public function addOrUpdateStock(StoreStockRequest $request)
    {
        try {
            $fields = $request->validated();

            $parseExpiresAt = Carbon::parse($fields['expires_at']);
            $expiresAt = $parseExpiresAt->toDateString();

            $stock = Stock::updateOrCreate(
                [
                    'product_id' => $fields['product_id'],
                    'warehouse_id' => $fields['warehouse_id'],
                ],
                [

                    'quantity' => $fields['quantity'],
                    'expires_at' => $expiresAt,
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'You changes has been saved',
                'stock' => $stock
            ], 201);
        } catch (Exception $e) {
            Log::error('Unable to manage your stock. Error: ' . $e->getMessage() . " Line: " . $e->getLine());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
