<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Urun 1',
            'image' => "images/shoe_1.jpg",
            'short_text'=> 'Kısabilgi',
            'price'=> 100,
            'category_id'=> 1,
            'content'=> '<p>Ürün baya İyi<p/>',
            'size'=> 'Small',
            'qty'=> 10,
            'status'=> '1',
            'color'=> 'Beyaz'
        ]);

        Product::create([
            'name' => 'Urun 2',
            'image' => "images/cloth_2.jpg",
            'short_text'=> 'Kısabilgi',
            'price'=> 150,
            'category_id'=> 2,
            'content'=> '<p>Ürün Açıklama<p/>',
            'size'=> 'Large',
            'qty'=> 5,
            'status'=> '1',
            'color'=> 'Siyah'




        ]);
    }
}
