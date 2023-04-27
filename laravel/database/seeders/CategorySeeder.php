<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'id'=> '1',
            'nombre' => 'peli',
        ]);
        DB::table('categories')->insert([
            'id'=> '2',
            'nombre' => 'serie',
        ]);
        
    }
}
