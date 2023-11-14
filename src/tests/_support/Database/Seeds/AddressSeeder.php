<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_BR');

        $factories = [
            [
                'patient_id' => 1,
                'zip_code' => '69317478',
                'street' => 'Rua Indus, 100',
                'number' => '100',
                'neighborhood' => 'Cidade Satélite',
                'city' => 'Boa Vista',
                'state_id' => 1,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 2,
                'zip_code' => '55602432',
                'street' => '1ª Travessa Almirante Saldanha da Gama, 200',
                'number' => '200',
                'complement' => 'A',
                'neighborhood' => 'Livramento',
                'city' => 'Vitória de Santo Antão',
                'state_id' => 2,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 3,
                'zip_code' => '72307804',
                'street' => 'Quadra QR 317 Conjunto 4, 300',
                'number' => '300',
                'complement' => 'Y',
                'neighborhood' => 'Samambaia Sul (Samambaia)',
                'city' => 'Brasília',
                'state_id' => 3,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 4,
                'zip_code' => '49065510',
                'street' => 'Travessa C, 400',
                'number' => '400',
                'neighborhood' => 'Industrial',
                'city' => 'Aracaju',
                'state_id' => 4,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 5,
                'zip_code' => '25555210',
                'street' => 'Rua Antônio Belchior, 500',
                'number' => '500',
                'neighborhood' => 'Jardim Meriti',
                'city' => 'São João de Meriti',
                'state_id' => 5,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 6,
                'zip_code' => '61944760',
                'street' => 'Rua das Flores, 600',
                'number' => '600',
                'neighborhood' => 'Centro',
                'city' => 'Fortaleza',
                'state_id' => 6,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 7,
                'zip_code' => '85904140',
                'street' => 'Rua da Praia, 700',
                'number' => '700',
                'complement' => 'B',
                'neighborhood' => 'Centro',
                'city' => 'Curitiba',
                'state_id' => 7,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 8,
                'zip_code' => '58066260',
                'street' => 'Rua da República, 800',
                'number' => '800',
                'complement' => 'A',
                'neighborhood' => 'Centro',
                'city' => 'João Pessoa',
                'state_id' => 8,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 9,
                'zip_code' => '73512080',
                'street' => 'Rua da Paz, 900',
                'number' => '900',
                'neighborhood' => 'Centro',
                'city' => 'São José do Rio Preto',
                'state_id' => 9,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 10,
                'zip_code' => '78555320',
                'street' => 'Rua da Alegria, 1000',
                'number' => '1000',
                'neighborhood' => 'Centro',
                'city' => 'Sinop',
                'state_id' => 10,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 11,
                'zip_code' => '88301140',
                'street' => 'Rua do Amor, 1100',
                'number' => '1100',
                'neighborhood' => 'Centro',
                'city' => 'Florianópolis',
                'state_id' => 11,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 12,
                'zip_code' => '75001550',
                'street' => 'Rua da Esperança, 1200',
                'number' => '1200',
                'neighborhood' => 'Centro',
                'city' => 'Goiânia',
                'state_id' => 12,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 13,
                'zip_code' => '69097040',
                'street' => 'Rua da Fé, 1300',
                'number' => '1300',
                'complement' => 'D',
                'neighborhood' => 'Centro',
                'city' => 'Manaus',
                'state_id' => 13,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 14,
                'zip_code' => '51020020',
                'street' => 'Rua da Luz, 1400',
                'number' => '1400',
                'complement' => 'C',
                'neighborhood' => 'Centro',
                'city' => 'Porto Alegre',
                'state_id' => 14,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 15,
                'zip_code' => '69316305',
                'street' => 'Rua OP-XXIII',
                'number' => '1400',
                'complement' => 'A',
                'neighborhood' => 'Operário',
                'city' => 'Porto Alegre',
                'state_id' => 15,
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
        ];

        $builder = $this->db->table('addresses');

        foreach ($factories as $factory) {
            $builder->insert($factory);
        }
    }
}
