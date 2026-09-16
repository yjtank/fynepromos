<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            ['name' => 'Amazon', 'website' => 'https://www.amazon.com.br'],
            ['name' => 'Kabum', 'website' => 'https://www.kabum.com.br'],
            ['name' => 'Mercado Livre', 'website' => 'https://www.mercadolivre.com.br'],
            ['name' => 'Magalu', 'website' => 'https://www.magazineluiza.com.br'],
            ['name' => 'Pichau', 'website' => 'https://www.pichau.com.br'],
            ['name' => 'AliExpress', 'website' => 'https://pt.aliexpress.com'],
        ];

        foreach ($stores as $store) {
            Store::updateOrCreate(
                ['slug' => Str::slug($store['name'])],
                [
                    'name' => $store['name'],
                    'website' => $store['website'],
                    'active' => true,
                ]
            );
        }
    }
}
