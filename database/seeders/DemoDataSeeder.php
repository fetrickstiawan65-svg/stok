<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Product;
use App\Models\StoreSetting;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $catBahan = Category::firstOrCreate(['name' => 'Bahan Bangunan']);
        $catCat = Category::firstOrCreate(['name' => 'Cat & Finishing']);
        $catBesi = Category::firstOrCreate(['name' => 'Besi & Baja']);
        $catKeramik = Category::firstOrCreate(['name' => 'Keramik']);

        $pcs = Unit::firstOrCreate(['name' => 'Pieces', 'symbol' => 'pcs']);
        $sak = Unit::firstOrCreate(['name' => 'Sak', 'symbol' => 'sak']);
        $kg  = Unit::firstOrCreate(['name' => 'Kilogram', 'symbol' => 'kg']);

        Product::firstOrCreate(
            ['code' => 'SEMEN-001'],
            ['name' => 'Semen 50kg', 'category_id' => $catBahan->id, 'unit_id' => $sak->id, 'cost_price' => 55000, 'sell_price' => 65000, 'stock_minimum' => 10, 'current_stock' => 0, 'is_active' => true]
        );

        Product::firstOrCreate(
            ['code' => 'PASIR-001'],
            ['name' => 'Pasir (per kg)', 'category_id' => $catBahan->id, 'unit_id' => $kg->id, 'cost_price' => 800, 'sell_price' => 1200, 'stock_minimum' => 100, 'current_stock' => 0, 'is_active' => true]
        );

        Product::firstOrCreate(
            ['code' => 'PAKU-001'],
            ['name' => 'Paku 5cm', 'category_id' => $catBahan->id, 'unit_id' => $pcs->id, 'cost_price' => 200, 'sell_price' => 400, 'stock_minimum' => 200, 'current_stock' => 0, 'is_active' => true]
        );

        Product::firstOrCreate(
            ['code' => 'CAT-001'],
            ['name' => 'Cat Tembok 5kg', 'category_id' => $catCat->id, 'unit_id' => $pcs->id, 'cost_price' => 85000, 'sell_price' => 105000, 'stock_minimum' => 5, 'current_stock' => 0, 'is_active' => true]
        );

        Product::firstOrCreate(
            ['code' => 'BESI-001'],
            ['name' => 'Besi Beton 10mm', 'category_id' => $catBesi->id, 'unit_id' => $pcs->id, 'cost_price' => 48000, 'sell_price' => 60000, 'stock_minimum' => 10, 'current_stock' => 0, 'is_active' => true]
        );

        Product::firstOrCreate(
            ['code' => 'KERAMIK-001'],
            ['name' => 'Keramik 40x40', 'category_id' => $catKeramik->id, 'unit_id' => $pcs->id, 'cost_price' => 45000, 'sell_price' => 60000, 'stock_minimum' => 10, 'current_stock' => 0, 'is_active' => true]
        );

        StoreSetting::firstOrCreate(['id' => 1], [
            'store_name' => 'Toko Bangunan Demo',
            'address' => 'Alamat toko…',
            'phone' => '08xxxxxxxxxx',
            'tax_enabled' => false,
            'tax_percent' => 0,
            'rounding_enabled' => false,
            'rounding_mode' => 'NONE',
            'rounding_to' => 100,
        ]);
    }
}
