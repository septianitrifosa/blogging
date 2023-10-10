<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        // Buat 25 artikel dummy
        for ($i = 0; $i < 25; $i++) {
            // Generate kalimat dengan panjang 6 kata
            $title = $faker->sentence(6);
            // Generate link untuk url gambar
            $image = $faker->imageUrl(800, 600, 'cats', true, 'Faker');
            // Generate paragraf dengan panjang 20 kalimat
            $body = $faker->paragraph(20);
            // Generate angka acak antara 0 hingga 100
            $views = $faker->numberBetween(0, 1000);
            // Generate DateTime antara 3 bulan lall
            $published_at = $faker->dateTimeBetween('-5 years', 'now');

            DB::table('articles')->insert([
                'title' => $title,
                'image' => $image,
                'body' => $body,
                'views' => $views,
                'published_at' => $published_at,
                'created_at' => $published_at,
                'updated_at' => $published_at,

            ]);
        }
    }
}
