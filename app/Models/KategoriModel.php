<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori'; // Sesuaikan dengan nama tabel di database kamu
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_kategori'];
}