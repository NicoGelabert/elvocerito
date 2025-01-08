<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('features')->insert([
            'title' => 'Potencie la identidad de su marca con servicios de branding profesionales',
            'image' => 'fi fi-rr-chart-histogram',
            'description' => 'Nuestros servicios integrales incluyen branding, diseño web y diseño gráfico para ayudar a que su negocio se destaque.',
        ]);
        DB::table('features')->insert([
            'title' => 'Cree experiencias de usuario atractivas con un diseño web innovador',
            'image' => 'fi fi-rs-hat-wizard',
            'description' => 'Cree experiencias de usuario atractivas con un diseño web innovador</h4>
            <p>Nuestro equipo de diseñadores creará un sitio web que cautive a su audiencia.',
        ]);
        DB::table('features')->insert([
            'title' => 'Eleve su marca con soluciones de diseño gráfico llamativas',
            'image' => 'fi fi-rs-rocket-lunch',
            'description' => 'Desde logotipos hasta materiales de marketing, crearemos imágenes atractivas que dejen una impresión duradera.',
        ]);
    }
}
