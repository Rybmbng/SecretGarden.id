<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductVariants extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'product_id' => ['type' => 'INT', 'null' => false],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'price'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'sku'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'stock'      => ['type' => 'INT', 'null' => true],
            'desc'      => ['type' => 'text', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_variants');
    }

    public function down()
    {
        $this->forge->dropTable('product_variants');
    }
}
