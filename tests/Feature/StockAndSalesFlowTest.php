<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockAndSalesFlowTest extends TestCase
{
    use RefreshDatabase;

    private function seedBasic()
    {
        $cat = Category::create(['name' => 'Bahan Bangunan']);
        $unit = Unit::create(['name' => 'Pieces', 'symbol' => 'pcs']);

        $p = Product::create([
            'code' => 'TEST-001',
            'name' => 'Produk Test',
            'category_id' => $cat->id,
            'unit_id' => $unit->id,
            'cost_price' => 1000,
            'sell_price' => 2000,
            'stock_minimum' => 0,
            'current_stock' => 0,
            'is_active' => true,
        ]);

        return $p;
    }

    public function test_login_page_accessible(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_sale_reduces_stock(): void
    {
        $product = $this->seedBasic();

        $admin = User::factory()->create(['role' => 'admin']);

        // set stock awal langsung untuk test (tanpa StockService biar simple)
        $product->update(['current_stock' => 10]);

        $resp = $this->actingAs($admin)->post(route('sales.checkout'), [
            'date' => date('Y-m-d'),
            'discount_total' => 0,
            'payment_method' => 'cash',
            'paid_amount' => 20000,
            'items' => [
                ['product_id' => $product->id, 'qty' => 2],
            ],
        ]);

        $resp->assertStatus(302);
        $product->refresh();
        $this->assertEquals(8, $product->current_stock);
    }
}
