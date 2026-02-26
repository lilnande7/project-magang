<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'D III Teknik Penerbangan Udara',
                'code' => 'D3-TPU',
                'description' => 'Koleksi buku dan referensi untuk Program Studi D III Teknik Penerbangan Udara',
                'is_active' => true
            ],
            [
                'name' => 'D III Teknik Bangunan dan Bandar Udara', 
                'code' => 'D3-TBU',
                'description' => 'Koleksi buku dan referensi untuk Program Studi D III Teknik Bangunan dan Bandar Udara',
                'is_active' => true
            ],
            [
                'name' => 'D III Elektronika Bandar Udara',
                'code' => 'D3-EAU', 
                'description' => 'Koleksi buku dan referensi untuk Program Studi D III Elektronika Bandar Udara',
                'is_active' => true
            ],
            [
                'name' => 'D III Keselamatan Penerbangan Udara',
                'code' => 'D3-KPU',
                'description' => 'Koleksi buku dan referensi untuk Program Studi D III Keselamatan Penerbangan Udara',
                'is_active' => true
            ],
            [
                'name' => 'Umum',
                'code' => 'UMUM',
                'description' => 'Koleksi buku umum dan referensi lintas program studi',
                'is_active' => true
            ],
            [
                'name' => 'Jurnal & Penelitian',
                'code' => 'JURNAL',
                'description' => 'Jurnal ilmiah dan hasil penelitian',
                'is_active' => true
            ]
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
