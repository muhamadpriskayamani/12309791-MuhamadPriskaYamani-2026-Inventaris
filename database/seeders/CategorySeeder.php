<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'division_pj' => 'Sarpras',
            ],
            [
                'name' => 'Peralatan Kantor',
                'division_pj' => 'Tata Usaha',
            ],
            [
                'name' => 'Peralatan Praktik',
                'division_pj' => 'Tefa',
            ],
            [
                'name' => 'Kebersihan',
                'division_pj' => 'Sarpras',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
