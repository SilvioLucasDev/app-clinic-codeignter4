<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(StateSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(AddressSeeder::class);
    }
}
