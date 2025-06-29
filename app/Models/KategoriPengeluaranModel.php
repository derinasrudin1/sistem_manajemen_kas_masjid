<?php namespace App\Models;

use CodeIgniter\Model;

class KategoriPengeluaranModel extends Model
{
    protected $table = 'kategori_pengeluaran';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = ['nama_kategori'];
    protected $returnType = 'array';
    
    // Tidak perlu override findAll() kecuali ada logika khusus
}