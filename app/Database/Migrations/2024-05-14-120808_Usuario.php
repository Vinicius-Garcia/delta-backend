<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usuario extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'    => True
            ],
            'name'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 255
            ],
            'email'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 255
            ],
            'senha'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 200
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('usuario', true);
    }
    public function down()
    {
        $this->forge->dropTable('usuario');
    }
}
