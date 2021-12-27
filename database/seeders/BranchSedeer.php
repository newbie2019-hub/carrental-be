<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSedeer extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'V&G Branch', 'address' => 'Sample address for the branch goes here.'],
            ['name' => 'Calanipawan Branch', 'address' => 'Sample address for the branch goes here.'],
            ['name' => 'Abucay Branch', 'address' => 'Sample address for the branch goes here.'],
            ['name' => 'Palo Branch', 'address' => 'Sample address for the branch goes here.'],
        ];

        foreach($data as $branch){
            Branch::create($branch);
        }
    }
}
