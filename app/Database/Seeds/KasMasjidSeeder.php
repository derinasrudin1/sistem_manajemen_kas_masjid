<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KasMasjidSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        // Insert admin & bendahara
        $users = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'nama' => 'Admin Masjid',
                'role' => 'admin',
            ],
            [
                'username' => 'bendahara',
                'password' => password_hash('bendahara123', PASSWORD_DEFAULT),
                'nama' => 'Bendahara Masjid',
                'role' => 'bendahara',
            ],
        ];
        $this->db->table('users')->insertBatch($users);

        // Sumber Dana
        $sumber = ['Kotak Amal', 'Transfer Bank', 'Donatur Tetap', 'Lainnya'];
        foreach ($sumber as $nama) {
            $this->db->table('sumber_dana')->insert(['nama_sumber' => $nama]);
        }

        // Kategori Pengeluaran
        $kategori = ['Listrik', 'Air', 'Perlengkapan Masjid', 'Kegiatan Ramadhan'];
        foreach ($kategori as $nama) {
            $this->db->table('kategori_pengeluaran')->insert(['nama_kategori' => $nama]);
        }

        // Ambil user ID random
        $userIDs = $this->db->table('users')->select('id_user')->get()->getResultArray();
        $userIDs = array_column($userIDs, 'id_user');

        // Kas Masuk (20 data)
        for ($i = 0; $i < 20; $i++) {
            $this->db->table('kas_masuk')->insert([
                'tanggal' => $faker->date(),
                'jumlah' => $faker->numberBetween(10000, 200000),
                'sumber' => $faker->randomElement($sumber),
                'keterangan' => $faker->sentence(),
                'id_user' => $faker->randomElement($userIDs)
            ]);
        }

        // Kas Keluar (15 data)
        for ($i = 0; $i < 15; $i++) {
            $this->db->table('kas_keluar')->insert([
                'tanggal' => $faker->date(),
                'jumlah' => $faker->numberBetween(10000, 150000),
                'kategori' => $faker->randomElement($kategori),
                'keterangan' => $faker->sentence(),
                'id_user' => $faker->randomElement($userIDs)
            ]);
        }

        // Donasi Online (10 data)
        $metode = ['OVO', 'Dana', 'Transfer BCA', 'ShopeePay'];
        $status = ['pending', 'selesai'];
        for ($i = 0; $i < 10; $i++) {
            $this->db->table('donasi_online')->insert([
                'nama_donatur' => $faker->name,
                'nominal' => $faker->numberBetween(50000, 500000),
                'tanggal' => $faker->date(),
                'metode' => $faker->randomElement($metode),
                'status' => $faker->randomElement($status)
            ]);
        }

        // Riwayat Transaksi (10 data masuk, 10 data keluar)
        for ($i = 0; $i < 10; $i++) {
            $this->db->table('riwayat_transaksi')->insert([
                'jenis' => 'masuk',
                'tanggal' => $faker->date(),
                'jumlah' => $faker->numberBetween(20000, 300000),
                'keterangan' => 'Transaksi kas masuk',
                'id_user' => $faker->randomElement($userIDs)
            ]);
            $this->db->table('riwayat_transaksi')->insert([
                'jenis' => 'keluar',
                'tanggal' => $faker->date(),
                'jumlah' => $faker->numberBetween(15000, 250000),
                'keterangan' => 'Transaksi kas keluar',
                'id_user' => $faker->randomElement($userIDs)
            ]);
        }
    }
}
