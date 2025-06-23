<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKasKeluarTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kas_keluar' => [
                'type' => 'INT',
                'unsigned' => true, // Tambahan: Praktik terbaik
                'auto_increment' => true
            ],
            'tanggal' => ['type' => 'DATE'],
            'jumlah' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'kategori' => ['type' => 'VARCHAR', 'constraint' => 100],
            'keterangan' => ['type' => 'TEXT', 'null' => true],
            'id_user' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
        ]);
        $this->forge->addKey('id_kas_keluar', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->createTable('kas_keluar');
    }

    public function down()
    {
        $this->forge->dropTable('kas_keluar');
    }
}
