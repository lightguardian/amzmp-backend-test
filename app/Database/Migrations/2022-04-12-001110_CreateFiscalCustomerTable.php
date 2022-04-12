<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFiscalCustomerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'creator_user' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'cnpj' => [
                'type' => 'VARCHAR',
                'constraint' => '14',
            ],
            'corporate_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'trade_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('cnpj');
        $this->forge->addForeignKey('creator_user', 'user', 'id');
        $this->forge->createTable('fiscal_customer', true, ['engine' => 'innodb']);
    }

    public function down()
    {
        $this->forge->dropTable('fiscal_customer');
    }
}
