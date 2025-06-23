<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi' => ['type' => 'INT', 'auto_increment' => true],
            'jenis' => ['type' => 'ENUM', 'constraint' => ['masuk', 'keluar']],
            'tanggal' => ['type' => 'DATE'],
            'jumlah' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'keterangan' => ['type' => 'TEXT', 'null' => true],
            'id_user' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
        ]);
        $this->forge->addKey('id_transaksi', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->createTable('riwayat_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('riwayat_transaksi');
    }
}
