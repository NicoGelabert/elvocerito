<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clients')->insert([
            'title' => 'ETER, Escuela de Comunicación',
        ]);
        DB::table('clients')->insert([
            'title' => 'Sur Comunica',
        ]);
        DB::table('clients')->insert([
            'title' => 'Inspiración Rolling Stone',
        ]);
        DB::table('clients')->insert([
            'title' => 'Licenciada Graciela Antes',
        ]);
        DB::table('clients')->insert([
            'title' => 'Rada Zapatos',
        ]);
        DB::table('clients')->insert([
            'title' => 'Bamboo Sushi & Wok',
        ]);
        DB::table('clients')->insert([
            'title' => 'Escuela de Creativos Publicitarios',
        ]);
    }
}
