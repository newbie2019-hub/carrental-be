<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admininfo = AdminInfo::create([
            'first_name' => 'Yvan',
            'middle_name' => 'Caindoy',
            'last_name' => 'Sabay',
            'gender' => 'Male',
            'contact_number' => '09355310166'
        ]);

        Admin::create([
            'email' => 'carrentaladmin@gmail.com',
            'password' => Hash::make('123123'),
            'admin_info_id' => $admininfo->id
        ]);
    }
}
