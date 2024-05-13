<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'    => True
            ],
            'title'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 200
            ],
            'price'    => [
                'type'          => 'INT',
                'constraint'    => 11,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products', true);
    }
    public function down()
    {
        $this->forge->dropTable('products');
    }
}
