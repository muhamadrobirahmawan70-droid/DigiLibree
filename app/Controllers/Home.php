<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Sesuaikan dengan nama session login kamu (id atau id_user)
        $userId = session()->get('id'); 
        $role   = session()->get('role');

        // --- DATA GRAFIK (HANYA UNTUK ADMIN) ---
        $grafik = [];
        if ($role == 'admin') {
            $grafik = $db->table('peminjaman')
                ->select('buku.judul, COUNT(peminjaman.id_buku) as total')
                ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                ->groupBy('peminjaman.id_buku')
                ->orderBy('total', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();
        }

        $data = [
            'title'          => 'Dashboard Perpustakaan',
            'grafik'         => $grafik,
            
            // --- DATA GLOBAL ---
            'total_buku'     => $db->table('buku')->countAllResults(),
            'total_kategori' => $db->table('kategori')->countAllResults(),

            // --- DATA KHUSUS ADMIN ---
            'total_member'   => $db->table('users')->where('role', 'anggota')->countAllResults(),
            'total_pinjam'   => $db->table('peminjaman')->countAllResults(),
            
            'total_denda_lunas'   => $db->table('peminjaman')->where('status_denda', 'lunas')->selectSum('denda')->get()->getRow()->denda ?? 0,
            'total_denda_piutang' => $db->table('peminjaman')->where('status_denda', 'belum_bayar')->selectSum('denda')->get()->getRow()->denda ?? 0,

            // --- DATA KHUSUS USER (ANGGOTA) ---
            // Buku yang lagi dibawa (status 'dipinjam' atau 'disetujui')
            'my_pinjam'  => $db->table('peminjaman')
                                ->where('id_user', $userId)
                                ->whereIn('status', ['dipinjam', 'disetujui'])
                                ->countAllResults(),
            
            // Total semua riwayat pinjam user tersebut
            'my_history' => $db->table('peminjaman')
                                ->where('id_user', $userId)
                                ->countAllResults(),

            // Total denda yang BELUM dibayar user ini
            'my_denda'   => $db->table('peminjaman')
                                ->where('id_user', $userId)
                                ->where('status_denda', 'belum_bayar')
                                ->selectSum('denda')
                                ->get()->getRow()->denda ?? 0,
        ];

        return view('layouts/dashboard', $data);
    }
}