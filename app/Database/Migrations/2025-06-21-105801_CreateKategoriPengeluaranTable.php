<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriPengeluaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kategori' => ['type' => 'INT', 'auto_increment' => true],
            'nama_kategori' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id_kategori', true);
        $this->forge->createTable('kategori_pengeluaran');
    }

    public function down()
    {
        $this->forge->dropTable('kategori_pengeluaran');
    }
}
