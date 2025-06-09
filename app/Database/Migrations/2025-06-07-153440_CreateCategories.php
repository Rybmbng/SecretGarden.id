<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'img'         => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories');
    }
}
