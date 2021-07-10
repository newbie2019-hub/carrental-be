<?php

namespace Database\Seeders;

use App\Models\TransmissionType;
use Illuminate\Database\Seeder;

class TransmissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transmission = [
            ['type' => 'Manual'],
            ['type' => 'Automatic'],
        ];

        foreach($transmission as $trans){
            TransmissionType::create($trans);
        }
    }
}
