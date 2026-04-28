<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $userId = session()->get('id'); 
        $role   = session()->get('role');

        // --- DATA GRAFIK (DIBUAT GLOBAL AGAR SEMUA ROLE BISA LIHAT) ---
        $grafik = $db->table('peminjaman')
            ->select('buku.judul, COUNT(peminjaman.id_buku) as total')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->groupBy('peminjaman.id_buku')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data = [
            'title'          => 'Dashboard Perpustakaan',
            'grafik'         => $grafik, // Sekarang sudah ada isinya buat semua role
            
            // --- DATA GLOBAL ---
            'total_buku'     => $db->table('buku')->countAllResults(),
            'total_kategori' => $db->table('kategori')->countAllResults(),

            // --- DATA KHUSUS ADMIN & PETUGAS ---
            'total_member'   => $db->table('users')->where('role', 'anggota')->countAllResults(),
            'total_pinjam'   => $db->table('peminjaman')->where('status', 'disetujui')->countAllResults(),
            
            'total_denda_lunas'   => $db->table('peminjaman')->where('status_denda', 'lunas')->selectSum('denda')->get()->getRow()->denda ?? 0,
            'total_denda_piutang' => $db->table('peminjaman')->where('status_denda', 'belum_bayar')->selectSum('denda')->get()->getRow()->denda ?? 0,

            // --- DATA KHUSUS USER (ANGGOTA) ---
            'my_pinjam'  => $db->table('peminjaman')
                                ->where('id_user', $userId)
                                ->whereIn('status', ['dipinjam', 'disetujui'])
                                ->countAllResults(),
            
            'my_history' => $db->table('peminjaman')
                                ->where('id_user', $userId)
                                ->countAllResults(),

            'my_denda'   => $db->table('peminjaman')
                                ->where('id_user', $userId)
                                ->where('status_denda', 'belum_bayar')
                                ->selectSum('denda')
                                ->get()->getRow()->denda ?? 0,
        ];

        return view('layouts/dashboard', $data);
    }
}