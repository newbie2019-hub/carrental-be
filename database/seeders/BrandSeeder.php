<?php

namespace Database\Seeders;

use App\Models\CarBrands;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['brand' => 'Toyota'],
            ['brand' => 'Mitsubishi'],
            ['brand' => 'Suzuki'],
            ['brand' => 'Kia'],
            ['brand' => 'Honda'],
            ['brand' => 'Ford'],
            ['brand' => 'Nissan'],
        ];

        foreach($data as $brand){
            CarBrands::create($brand);
        }
    }
}
