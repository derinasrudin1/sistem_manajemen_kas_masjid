<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKasMasukTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kas_masuk' => [
                'type' => 'INT',
                'unsigned' => true, // Tambahan: Praktik terbaik
                'auto_increment' => true
            ],
            'tanggal' => ['type' => 'DATE'],
            'jumlah' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'sumber' => ['type' => 'VARCHAR', 'constraint' => 100],
            'keterangan' => ['type' => 'TEXT', 'null' => true],

            // INI BAGIAN YANG DIPERBAIKI
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true, // <-- TAMBAHKAN BARIS INI
                'null' => true
            ],
        ]);
        $this->forge->addKey('id_kas_masuk', true);

        // Baris foreign key ini sekarang akan berhasil
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'SET NULL');

        $this->forge->createTable('kas_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('kas_masuk');
    }
}