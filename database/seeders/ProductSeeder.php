<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => "Melon Hijau Lokal",
                "price" => 20000,
                "stock" => 50,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Golden Langkawi",
                "price" => 35000,
                "stock" => 30,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Honeydew Premium",
                "price" => 45000,
                "stock" => 20,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Cantaloupe Manis",
                "price" => 30000,
                "stock" => 40,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Snowball",
                "price" => 40000,
                "stock" => 25,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Kuning Emas",
                "price" => 25000,
                "stock" => 60,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Galia Tropis",
                "price" => 33000,
                "stock" => 35,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Piel de Sapo",
                "price" => 50000,
                "stock" => 15,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Shizuoka Jepang",
                "price" => 65000,
                "stock" => 10,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Sky Rocket",
                "price" => 38000,
                "stock" => 25,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Orange Dew",
                "price" => 28000,
                "stock" => 50,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Jade Dew",
                "price" => 43000,
                "stock" => 20,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Charentais Prancis",
                "price" => 55000,
                "stock" => 10,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Perisa Vanilla",
                "price" => 30000,
                "stock" => 45,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Aroma Pepaya",
                "price" => 25000,
                "stock" => 55,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Super Sweet",
                "price" => 45000,
                "stock" => 20,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Autumn Favor",
                "price" => 42000,
                "stock" => 18,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Crystal White",
                "price" => 27000,
                "stock" => 60,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon Aroma Pisang",
                "price" => 28000,
                "stock" => 40,
                "created_at" => now(),
                "updated_at" => now()
            ], [
                'name' => "Melon California Kiss",
                "price" => 60000,
                "stock" => 12,
                "created_at" => now(),
                "updated_at" => now()
            ]
        ]);
    }
}
