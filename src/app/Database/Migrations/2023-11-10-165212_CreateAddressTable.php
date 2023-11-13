<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAddressTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'patient_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'zip_code' => [
                'type' => 'VARCHAR',
                'constraint' => '8',
            ],
            'street' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'number' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'complement' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'neighborhood' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'state_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('state_id', 'states', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('addresses');
    }

    public function down()
    {
        $this->forge->dropTable('addresses');
    }
}
