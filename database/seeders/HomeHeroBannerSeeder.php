<?php

namespace Database\Seeders;

use App\Models\HomeHeroBanner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeHeroBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('home_hero_banners')->insert([
            'image' => 'storage/portfolio/el-parquimetro-homanaje-a-fernando-pena.jpg',
            'headline' => 'Clientes Únicos.<br>Diseños Únicos.',
            'description' => 'Desde logotipos hasta materiales de marketing. Creamos imágenes atractivas que dejan una impresión duradera',
            'service' => 'Diseño Gráfico',
            'title' => 'Homenaje a Fernando Peña',
        ]);
        DB::table('home_hero_banners')->insert([
            'image' => 'storage/portfolio/el-parquimetro-homanaje-a-fernando-pena.jpg',
            'headline' => 'Clientes Únicos.<br>Diseños Únicos.',
            'description' => 'Desde logotipos hasta materiales de marketing. Creamos imágenes atractivas que dejan una impresión duradera',
            'service' => 'Diseño Web',
            'title' => 'Homenaje a Fernando Peña',
        ]);
        DB::table('home_hero_banners')->insert([
            'image' => 'storage/portfolio/el-parquimetro-homanaje-a-fernando-pena.jpg',
            'headline' => 'Clientes Únicos.<br>Diseños Únicos.',
            'description' => 'Desde logotipos hasta materiales de marketing. Creamos imágenes atractivas que dejan una impresión duradera',
            'service' => 'Branding',
            'title' => 'Homenaje a Fernando Peña',
        ]);
    }
}
