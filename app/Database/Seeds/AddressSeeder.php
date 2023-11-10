<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_BR');

        $numberOfLines = 50;

        for ($i = 1; $i <= $numberOfLines; $i++) {
            $data = [
                'patient_id' => $faker->unique()->numberBetween(1, $numberOfLines),
                'zipcode' => str_replace('-', '', $faker->postcode()),
                'street' => $faker->streetName(),
                'number' => $faker->buildingNumber(),
                'complement' => $faker->secondaryAddress(),
                'neighborhood' => $faker->citySuffix(),
                'city' => $faker->city(),
                'state_id' => $faker->numberBetween(1, 27),
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ];

            $this->db->table('addresses')->insert($data);
        }
    }
}
