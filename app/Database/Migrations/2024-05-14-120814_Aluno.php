<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Aluno extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'    => True
            ],
            'nome'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 255
            ],
            'email'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 255
            ],
            'telefone'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 255
            ],
            'endereco'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 255
            ],
            'foto'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('aluno', true);
    }
    public function down()
    {
        $this->forge->dropTable('aluno');
    }
}
