<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // ['type' => 'Paypal'],
            ['type' => 'Credit Card'],
            ['type' => 'Pay at branch'],
        ];

        foreach($data as $type){
            PaymentType::create($type);
        }
    }
}
