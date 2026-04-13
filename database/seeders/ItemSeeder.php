<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'Laptop Asus',
                'total' => 10,
                'category_id' => 1,
            ],
            [
                'name' => 'Proyektor Epson',
                'total' => 5,
                'category_id' => 2,
            ],
            [
                'name' => 'Meja Praktik',
                'total' => 15,
                'category_id' => 3,
            ],
            [
                'name' => 'Kursi Kantor',
                'total' => 20,
                'category_id' => 2,
            ],
            [
                'name' => 'Alat Kebersihan Set',
                'category_id' => 4,
                'total' => 8,
            ],
            [
                'name' => 'Komputer',
                'category_id' => 1,
                'total' => 130,
            ],
            [
                'name' => 'Laptop',
                'category_id' => 1,
                'total' => 210,
            ],
            [
                'name' => 'Printer',
                'category_id' => 1,
                'total' => 50,
            ],
            [
                'name' => 'Mouse',
                'category_id' => 1,
                'total' => 45,
            ],
            [
                'name' => 'Keyboard',
                'category_id' => 1,
                'total' => 40,
            ],
            [
                'name' => 'Monitor',
                'category_id' => 1,
                'total' => 25,
            ],
            [
                'name' => 'Proyektor',
                'category_id' => 1,
                'total' => 10,
            ],
            [
                'name' => 'Scanner',
                'category_id' => 1,
                'total' => 8,
            ],
            [
                'name' => 'Speaker',
                'category_id' => 1,
                'total' => 15,
            ],
            [
                'name' => 'Harddisk Eksternal',
                'category_id' => 1,
                'total' => 12,
            ],
            // Alat Dapur (category_id: 2
            [
                'name' => 'Piring',
                'category_id' => 2,
                'total' => 100,
            ],
            [
                'name' => 'Gelas',
                'category_id' => 2,
                'total' => 89,
            ],
            [
                'name' => 'Sendok',
                'category_id' => 2,
                'total' => 75,
            ],
            [
                'name' => 'Garpu',
                'category_id' => 2,
                'total' => 75,
            ],
            [
                'name' => 'Pisau Dapur',
                'category_id' => 2,
                'total' => 20,
            ],
            [
                'name' => 'Wajan',
                'category_id' => 2,
                'total' => 10,
            ],
            [
                'name' => 'Panci',
                'category_id' => 2,
                'total' => 12,
            ],
            [
                'name' => 'Rice Cooker',
                'category_id' => 2,
                'total' => 5,
            ],
            [
                'name' => 'Blender',
                'category_id' => 2,
                'total' => 6,
            ],
            [
                'name' => 'Talenan',
                'category_id' => 2,
                'total' => 15,
            ],

            // Perlengkapan Kantor (category_id: 3
            [
                'name' => 'Meja',
                'category_id' => 3,
                'total' => 50,
            ],
            [
                'name' => 'Kursi',
                'category_id' => 3,
                'total' => 75,
            ],
            [
                'name' => 'Meja',
                'category_id' => 3,
                'total' => 50,
            ],
            [
                'name' => 'Lemari Arsip',
                'category_id' => 3,
                'total' => 10,
            ],
            [
                'name' => 'Papan Tulis',
                'category_id' => 3,
                'total' => 5,
            ],
            [
                'name' => 'Stapler',
                'category_id' => 3,
                'total' => 30,
            ],
            [
                'name' => 'Gunting',
                'category_id' => 3,
                'total' => 20,
            ],
            [
                'name' => 'Perforator',
                'category_id' => 3,
                'total' => 10,
            ],
            [
                'name' => 'Lampu Meja',
                'category_id' => 3,
                'total' => 15,
            ],
            [
                'name' => 'Kotak Sampah',
                'category_id' => 3,
                'total' => 25,
            ],

        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
