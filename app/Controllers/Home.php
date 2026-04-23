<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('id_user'); 

        $data = [
            // --- DATA GLOBAL (ADMIN & USER BISA LIHAT) ---
            'total_buku'     => $db->table('buku')->countAllResults(),
            'total_kategori' => $db->table('kategori')->countAllResults(),

            // --- DATA KHUSUS ADMIN ---
            'total_member'   => $db->table('users')->where('role', 'anggota')->countAllResults(),
            'total_pinjam'   => $db->table('peminjaman')->countAllResults(),
            
            // Statistik Denda untuk Admin (Pendapatan vs Piutang)
            'total_denda_lunas'   => $db->table('peminjaman')->where('status_denda', 'lunas')->selectSum('denda')->get()->getRow()->denda ?? 0,
            'total_denda_piutang' => $db->table('peminjaman')->where('status_denda', 'belum_bayar')->selectSum('denda')->get()->getRow()->denda ?? 0,

            // --- DATA KHUSUS USER (ANGGOTA) ---
            // Buku yang lagi dibawa
            'my_pinjam'  => $db->table('peminjaman')
                               
                               
                               ->countAllResults(),
            
            // Total riwayat pinjam (semua status)
            'my_history' => $db->table('peminjaman')
                               
                               ->countAllResults(),

            // Total denda yang BELUM dibayar oleh user ini saja
            'my_denda'   => $db->table('peminjaman')
                               ->where('id_user', $userId)
                               ->where('status_denda', 'belum_bayar')
                               ->selectSum('denda')
                               ->get()->getRow()->denda ?? 0,
        ];

        return view('layouts/dashboard', $data);
    }
}