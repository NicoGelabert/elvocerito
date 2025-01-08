<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $espStates = [
                "AL" => 'Alava',
                "AB" => 'Albacete',
                "A" => 'Alicante - Alacant',
                "ALM" => 'Almería',
                "AV" => 'Ávila',
                "BA" => 'Badajoz',
                "PM" => 'Illes Balears',
                "B" => 'Barcelona',
                "BU" => 'Burgos',
                "CC" => 'Cáceres',
                "CA" => 'Cádiz',
                "CS" => 'Castellón - Castelló',
                "CR" => 'Ciudad Real',
                "CO" => 'Córdoba',
                "C" => 'A Coruña',
                "CU" => 'Cuenca',
                "GI" => 'Girona',
                "GR" => 'Granada',
                "GU" => 'Guadalajara',
                "SS" => 'Gipuzkoa',
                "H" => 'Huelva',
                "HU" => 'Huesca',
                "J" => 'Jaén',
                "LE" => 'León',
                "L" => 'Lleida',
                "LO" => 'La Rioja',
                "LU" => 'Lugo',
                "M" => 'Madrid',
                "MA" => 'Málaga',
                "MU" => 'Murcia',
                "NA" => 'Navarra',
                "OR" => 'Ourense',
                "O" => 'Asturias',
                "P" => 'Palencia',
                "GC" => 'Las Palmas',
                "PO" => 'Pontevedra',
                "SA" => 'Salamanca',
                "TF" => 'Santa Cruz de Tenerife',
                "S" => 'Cantabria',
                "SG" => 'Segovia',
                "SE" => 'Sevilla',
                "SO" => 'Soria',
                "T" => 'Tarragona',
                "TE" => 'Teruel',
                "TO" => 'Toledo',
                "V" => 'Valencia - Valladolid',
                "BI" => 'Bizkaia',
                "ZA" => 'Zamora',
                "Z" => 'Zaragoza',
                "CE" => 'Ceuta',
                "ML" => 'Melilla'
            ];
            $countries = [
                ['code' => 'esp', 'name' => 'España', 'states' => json_encode($espStates)],
            ];
            Country::insert($countries);
        }
    }
}
