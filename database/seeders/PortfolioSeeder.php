<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('portfolios')->insert([
            'title' => 'Homenaje a Fernando Peña',
            'image' => 'storage/portfolio/el-parquimetro-homanaje-a-fernando-pena.jpg',
            'client_id' => 1,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Promo Carrera de Producción',
            'image' => 'storage/portfolio/publi-carrera-produccion.jpg',
            'client_id' => 1,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Mick',
            'image' => 'storage/portfolio/eter-sos-lo-que-estudias.png',
            'client_id' => 1,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Isologo Sur Comunica',
            'image' => 'storage/portfolio/isologo-sur-comunica.jpg',
            'client_id' => 2,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Arte Stone',
            'image' => 'storage/portfolio/arte-stone.jpg',
            'client_id' => 3,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Amor',
            'image' => 'storage/portfolio/amor.jpg',
            'client_id' => 4,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Isologo 100 años de radio',
            'image' => 'storage/portfolio/isologo-100-anos-de-radio.jpg',
            'client_id' => 1,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Logo Rada',
            'image' => 'storage/portfolio/logotipo-rada.jpg',
            'client_id' => 5,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Promo ETER Carreras',
            'image' => 'storage/portfolio/publi-eter-carreras.jpg',
            'client_id' => 1,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Isologo Bamboo',
            'image' => 'storage/portfolio/isologo-bamboo-sushi-wok.jpg',
            'client_id' => 6,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Publi Johnnie Walker',
            'image' => 'storage/portfolio/publi-johnny-walker.jpg',
            'client_id' => 7,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Diseño Editorial - Skatalites',
            'image' => 'storage/portfolio/editorial-skatalites.jpg',
            'client_id' => 7,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Diploma Premios ETER',
            'image' => 'storage/portfolio/premioseter-diploma.png',
            'client_id' => 1,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Efeméride 24 de marzo',
            'image' => 'storage/portfolio/nunca-mas-pandemia.jpg',
            'client_id' => 1,
        ]);
        DB::table('portfolios')->insert([
            'title' => 'Señalador ETER carreras',
            'image' => 'storage/portfolio/eter-senalador.png',
            'client_id' => 1,
        ]);
    }
}
