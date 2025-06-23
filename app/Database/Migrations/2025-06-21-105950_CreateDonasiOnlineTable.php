<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDonasiOnlineTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_donasi' => ['type' => 'INT', 'auto_increment' => true],
            'nama_donatur' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'nominal' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'tanggal' => ['type' => 'DATE'],
            'metode' => ['type' => 'VARCHAR', 'constraint' => 50],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'selesai'], 'default' => 'pending'],
        ]);
        $this->forge->addKey('id_donasi', true);
        $this->forge->createTable('donasi_online');
    }

    public function down()
    {
        $this->forge->dropTable('donasi_online');
    }
}
