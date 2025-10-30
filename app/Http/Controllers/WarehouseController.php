<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class WarehouseController extends Controller
{
    public function getWareHouseReport(Request $request, $id)
    {
        try {
            $warehouse = Warehouse::with('stock.product')
                ->findOrFail($id);

            $result = $warehouse->stock->map(function ($stock) {
                return [
                    'product_id' => $stock->product->id,
                    'name'       => $stock->product->name,
                    'quantity'   => $stock->quantity,
                ];
            });

            return response()->json([
                'warehouse' => $warehouse->name,
                'products'  => $result,
            ]);
        } catch (Exception $e) {
            Log::error('Unable to manage your stock. Error: ' . $e->getMessage() . " Line: " . $e->getLine());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
