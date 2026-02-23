<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockService
{
    private function runAtomic(callable $fn)
    {
        // Kalau sudah berada dalam transaction, jangan buat transaction baru.
        if (DB::transactionLevel() > 0) {
            return $fn();
        }
        return DB::transaction(fn() => $fn());
    }

    /**
     * Create stock movement and update product current_stock atomically.
     */
    public function createMovement(array $payload): StockMovement
    {
        return $this->runAtomic(function () use ($payload) {
            $product = Product::whereKey($payload['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $qtyIn = (int)($payload['qty_in'] ?? 0);
            $qtyOut = (int)($payload['qty_out'] ?? 0);

            if ($qtyIn < 0 || $qtyOut < 0) {
                throw ValidationException::withMessages(['qty' => 'Qty tidak boleh negatif.']);
            }
            if ($qtyIn > 0 && $qtyOut > 0) {
                throw ValidationException::withMessages(['qty' => 'Pilih salah satu: masuk atau keluar.']);
            }

            $newStock = $product->current_stock + $qtyIn - $qtyOut;

            if ($newStock < 0) {
                throw ValidationException::withMessages(['stock' => 'Stok tidak cukup.']);
            }

            $product->current_stock = $newStock;
            $product->save();

            $movement = StockMovement::create([
                'product_id' => $product->id,
                'type' => $payload['type'],
                'ref_type' => $payload['ref_type'] ?? null,
                'ref_id' => $payload['ref_id'] ?? null,
                'qty_in' => $qtyIn,
                'qty_out' => $qtyOut,
                'balance_after' => $newStock,
                'notes' => $payload['notes'] ?? null,
                'created_by' => $payload['created_by'],
            ]);

            return $movement;
        });
    }

    public function setOpeningStock(int $productId, int $qty, int $userId, ?string $notes = null): StockMovement
    {
        return $this->runAtomic(function () use ($productId, $qty, $userId, $notes) {
            $product = Product::whereKey($productId)->lockForUpdate()->firstOrFail();

            $hasAny = StockMovement::where('product_id', $productId)->exists();
            if ($hasAny) {
                throw ValidationException::withMessages(['opening' => 'Stok awal hanya boleh diinput 1x (belum ada pergerakan).']);
            }

            if ($qty < 0) {
                throw ValidationException::withMessages(['qty' => 'Qty tidak boleh negatif.']);
            }

            $product->current_stock = $qty;
            $product->save();

            return StockMovement::create([
                'product_id' => $product->id,
                'type' => 'OPENING',
                'ref_type' => 'MANUAL',
                'ref_id' => null,
                'qty_in' => $qty,
                'qty_out' => 0,
                'balance_after' => $qty,
                'notes' => $notes ?? 'Stok awal',
                'created_by' => $userId,
            ]);
        });
    }

    public function stockOpname(int $productId, int $actual, int $userId, ?string $notes = null): StockMovement
    {
        return $this->runAtomic(function () use ($productId, $actual, $userId, $notes) {
            $product = Product::whereKey($productId)->lockForUpdate()->firstOrFail();

            if ($actual < 0) {
                throw ValidationException::withMessages(['actual' => 'Stok aktual tidak boleh negatif.']);
            }

            $diff = $actual - $product->current_stock;

            if ($diff === 0) {
                throw ValidationException::withMessages(['actual' => 'Tidak ada selisih stok.']);
            }

            $qtyIn = $diff > 0 ? $diff : 0;
            $qtyOut = $diff < 0 ? abs($diff) : 0;

            return $this->createMovement([
                'product_id' => $productId,
                'type' => 'ADJUST',
                'ref_type' => 'OPNAME',
                'ref_id' => null,
                'qty_in' => $qtyIn,
                'qty_out' => $qtyOut,
                'notes' => $notes ?? 'Stock opname',
                'created_by' => $userId,
            ]);
        });
    }
}
