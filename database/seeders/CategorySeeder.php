<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Notebooks',
            'Celulares',
            'Periféricos',
            'Gamer',
            'Monitores',
            'Acdessórios'
        ];

        foreach ($categories as $name) {

            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'active' => true,
                ]
            );

        }
    }


}
