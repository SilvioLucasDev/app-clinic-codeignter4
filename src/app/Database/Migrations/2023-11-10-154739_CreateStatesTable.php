<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStatesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'uf' => [
                'type' => 'VARCHAR',
                'constraint' => '2',
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('states');
    }

    public function down()
    {
        $this->forge->dropTable('states');
    }
}
