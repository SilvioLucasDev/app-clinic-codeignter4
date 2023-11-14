<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('StateSeeder');
        $this->call('PatientSeeder');
        $this->call('AddressSeeder');
    }
}
