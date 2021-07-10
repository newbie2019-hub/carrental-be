<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminAccountSeeder::class,
            TransmissionTypeSeeder::class,
            BrandSeeder::class,
            PaymentTypeSeeder::class,
        ]);
    }
}
