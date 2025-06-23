<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSumberDanaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sumber' => ['type' => 'INT', 'auto_increment' => true],
            'nama_sumber' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id_sumber', true);
        $this->forge->createTable('sumber_dana');
    }

    public function down()
    {
        $this->forge->dropTable('sumber_dana');
    }
}
