<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PatientSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_BR');

        for ($i = 1; $i <= 20; $i++) {
            $data = [
                'name' => $faker->name(),
                'mother_name' => $faker->name(),
                'birth_date' => $faker->date(),
                'cpf' => $faker->unique()->cpf(false),
                'cns' => $faker->numerify('###############'),
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ];

            $this->db->table('patients')->insert($data);
        }
    }
}
