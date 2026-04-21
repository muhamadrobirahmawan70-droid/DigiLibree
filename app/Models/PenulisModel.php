<?php

namespace App\Models;

use CodeIgniter\Model;

class PenulisModel extends Model
{
    protected $table            = 'penulis'; // Sesuaikan dengan nama tabel di database kamu
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_penulis'];
}