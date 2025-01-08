<?php

namespace Database\Seeders;

use App\Models\Tags;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            'title' => 'Sitio web nuevo',
            'service_id' => 1,
        ]);
        DB::table('tags')->insert([
            'title' => 'Rediseño sitio',
            'service_id' => 1,
        ]);
        DB::table('tags')->insert([
            'title' => 'Sitio institucional',
            'service_id' => 1,
        ]);
        DB::table('tags')->insert([
            'title' => 'E-commerce',
            'service_id' => 1,
        ]);
        DB::table('tags')->insert([
            'title' => 'Landing page',
            'service_id' => 1,
        ]);
        DB::table('tags')->insert([
            'title' => 'Mantenimiento Web',
            'service_id' => 1,
        ]);
        DB::table('tags')->insert([
            'title' => 'Identidad corporativa',
            'service_id' => 2,
        ]);
        DB::table('tags')->insert([
            'title' => 'Logo',
            'service_id' => 2,
        ]);
        DB::table('tags')->insert([
            'title' => 'Folletería impresa',
            'service_id' => 2,
        ]);
        DB::table('tags')->insert([
            'title' => 'Tarjetas y papelería corporativa',
            'service_id' => 2,
        ]);
        DB::table('tags')->insert([
            'title' => 'Menúes para hostelería',
            'service_id' => 2,
        ]);
        DB::table('tags')->insert([
            'title' => 'Diseño para redes sociales',
            'service_id' => 2,
        ]);
        DB::table('tags')->insert([
            'title' => 'Acciones de Marketing',
            'service_id' => 3,
        ]);
        DB::table('tags')->insert([
            'title' => 'Gestión de redes',
            'service_id' => 3,
        ]);
        DB::table('tags')->insert([
            'title' => 'Publicidad digital',
            'service_id' => 3,
        ]);
        DB::table('tags')->insert([
            'title' => 'Email marketing',
            'service_id' => 3,
        ]);
    }
}
