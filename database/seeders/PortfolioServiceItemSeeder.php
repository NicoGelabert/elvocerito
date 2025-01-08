<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortfolioServiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('portfolio_service_item')->insert([
            'portfolio_id' => 1,
            'service_item_id' => 10,
        ]);
        DB::table('portfolio_service_item')->insert([
            'portfolio_id' => 1,
            'service_item_id' => 11,
        ]);
        DB::table('portfolio_service_item')->insert([
            'portfolio_id' => 2,
            'service_item_id' => 11,
        ]);
        DB::table('portfolio_service_item')->insert([
            'portfolio_id' => 2,
            'service_item_id' => 12,
        ]);
        DB::table('portfolio_service_item')->insert([
            'portfolio_id' => 3,
            'service_item_id' => 10,
        ]);
        
        DB::table('portfolio_service_item')->insert([
            'portfolio_id' => 3,
            'service_item_id' => 11,
        ]);
        DB::table('portfolio_service_item')->insert([
            'portfolio_id' => 3,
            'service_item_id' => 12,
        ]);
        DB::table('portfolio_service_item')->insert([
            'portfolio_id' => 3,
            'service_item_id' => 15,
        ]);
        DB::table('portfolio_service_item')->insert([
            'portfolio_id' => 3,
            'service_item_id' => 16,
        ]);
    }
}
