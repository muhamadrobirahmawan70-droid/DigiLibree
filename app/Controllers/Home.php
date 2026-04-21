<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Ambil ID User yang sedang login dari session
        // Pastikan saat login, kamu sudah menyimpan 'id_user' di session
        $userId = session()->get('id_user'); 

        $data = [
            // DATA UNTUK ADMIN (Statistik Global)
            'total_buku'     => $db->table('buku')->countAllResults(),
            'total_pinjam'   => $db->table('peminjaman')->where('status', 'dipinjam')->countAllResults(),
            'total_member'   => $db->table('users')->where('role', 'anggota')->countAllResults(),
            'total_kategori' => $db->table('kategori')->countAllResults(),

            // DATA UNTUK USER (Statistik Personal)
            'my_pinjam'      => $db->table('peminjaman')->where('id_user', $userId)->where('status', 'dipinjam')->countAllResults(),
            'my_history'     => $db->table('peminjaman')->where('id_user', $userId)->countAllResults(),
        ];

        return view('layouts/dashboard', $data);
    }
}