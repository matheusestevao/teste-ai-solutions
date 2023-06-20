<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    protected $categories = [
        'remessa parcial',
        'remessa'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->categories as $category) {
            Category::updateOrCreate([
                'name' => ucwords(strtolower($category))
            ]);
        }
    }
}
