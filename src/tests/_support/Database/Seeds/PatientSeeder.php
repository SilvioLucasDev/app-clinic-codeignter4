<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PatientSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_BR');

        $factories = [
            [
                'name' => 'Sr. Fábio Maximiano Vieira Filho',
                'mother_name' => 'Sra. Ohana Jéssica da Rosa',
                'birth_date' => '1997-02-02',
                'cpf' => '03426673274',
                'cns' => '986111281430009',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Eunice Vale',
                'mother_name' => 'Sra. Cecília Beltrão Neto',
                'birth_date' => '2017-10-28',
                'cpf' => '26359625105',
                'cns' => '764543640340007',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Dr. Lucio Abreu Jr.',
                'mother_name' => 'Giovanna Stephany Delgado Sobrinho',
                'birth_date' => '1993-08-01',
                'cpf' => '63918132641',
                'cns' => '213760583990000',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Alan Albergaria Paulino Cocelo',
                'mother_name' => 'Lina Marica Zuniga Maia',
                'birth_date' => '1995-11-22',
                'cpf' => '63918132641',
                'cns' => '295042924630001',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Abraão Annunziato Jesus Firmino',
                'mother_name' => 'Maria Negris Bastida Braga',
                'birth_date' => '2004-06-14',
                'cpf' => '30022738053',
                'cns' => '963384807820004',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Elio Pinho Claudino Rocha',
                'mother_name' => 'Manuela Amorin Matta Zuniga',
                'birth_date' => '1989-08-26',
                'cpf' => '46125772306',
                'cns' => '216573198030018',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'José Maria Sousa Gomes Bastida',
                'mother_name' => 'Rachel Pimenta Reis Pedroso',
                'birth_date' => '1991-09-05',
                'cpf' => '13994739721',
                'cns' => '277467863440006',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Myrian Bastida Antunes Salles',
                'mother_name' => 'Evelyn Aguiar Carvalheiro Magalhães',
                'birth_date' => '2011-10-25',
                'cpf' => '28861294537',
                'cns' => '235022132500008',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Paulo Henrique Carvalheiro Serravalle Manhães',
                'mother_name' => 'Tereza Mattos Spilman Werling',
                'birth_date' => '1981-09-19',
                'cpf' => '95111882324',
                'cns' => '282324321360018',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Wellington Anjos Monteiro Estellet',
                'mother_name' => 'Tatiane Limeira Soares Machado',
                'birth_date' => '2006-11-16',
                'cpf' => '79127951898',
                'cns' => '201534477880002',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Reginaldo Mendonça Fundão Assis',
                'mother_name' => 'Maria Luiza Barboza Lucas de Jesus',
                'birth_date' => '2001-07-17',
                'cpf' => '45133452845',
                'cns' => '707495035210004',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Georgiane Kassab Reis Zava',
                'mother_name' => 'Fatima Rios Guerini Chaves',
                'birth_date' => '2001-07-17',
                'cpf' => '55210238520',
                'cns' => '759933603090000',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Jonathan Silvino Avilla Matta',
                'mother_name' => 'Marcela Brum da Paixão Castro',
                'birth_date' => '1984-05-28',
                'cpf' => '32415768685',
                'cns' => '293604470230003',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Levi Coutinho Guzzo Carneiro',
                'mother_name' => 'Viviane Quintela Alfradique Zava',
                'birth_date' => '2016-11-29',
                'cpf' => '31095245970',
                'cns' => '857027653610018',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'João Camelo Campos Zuniga',
                'mother_name' => 'Camila Schuenck Prata Jales',
                'birth_date' => '1975-05-16',
                'cpf' => '84626628001',
                'cns' => '981501447350005',
                'created_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
            ]
        ];

        $builder = $this->db->table('patients');

        foreach ($factories as $factory) {
            $builder->insert($factory);
        }
    }
}
