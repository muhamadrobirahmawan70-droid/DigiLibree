<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table      = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    // Pastikan field ini sesuai dengan kolom di database Anda
   protected $allowedFields = [
    'id_user', 'id_buku', 'tanggal_pinjam', 'tanggal_kembali', 
    'tanggal_pengembalian_asli', 'status', 'denda', 'status_denda','catatan','tanggal_selesai' // <-- Tambahkan ini
];

    /**
     * Mengambil semua data peminjaman dengan Join ke tabel Buku dan Users
     */
    public function getPeminjamanLengkap($id_user = null)
{
    $builder = $this->select('peminjaman.*, buku.judul, users.username')
                    ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                    ->join('users', 'users.id = peminjaman.id_user');
    
    if ($id_user) {
        $builder->where('peminjaman.id_user', $id_user);
    }

    return $builder->findAll();
}

    /**
     * Mencari data berdasarkan keyword (Judul Buku atau Nama User)
     */
    public function search($keyword)
    {
        return $this->select('peminjaman.*, buku.judul, users.username')
                    ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                    ->join('users', 'users.id = peminjaman.id_user')
                    ->like('buku.judul', $keyword)
                    ->orLike('users.username', $keyword);
    }
}