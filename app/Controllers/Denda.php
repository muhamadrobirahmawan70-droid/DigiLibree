<?php

namespace App\Controllers;

class Denda extends BaseController
{
    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Ambil data peminjaman yang statusnya terlambat atau sudah kembali tapi ada denda
        $builder = $this->db->table('peminjaman');
        $builder->select('peminjaman.*, users.nama, users.telepon, buku.judul');
        $builder->join('users', 'users.id = peminjaman.id_user');
        $builder->join('buku', 'buku.id_buku = peminjaman.id_buku');
        $builder->where('peminjaman.denda >', 0); // Hanya yang punya denda
        
        $data = [
            'title' => 'Data Denda | DigiLibree',
            'denda' => $builder->get()->getResultArray()
        ];

        return view('denda/index', $data);
    }

    public function kirimPeringatan($idPeminjaman)
    {
        $peminjaman = $this->db->table('peminjaman')
            ->select('peminjaman.*, users.nama, users.telepon, buku.judul')
            ->join('users', 'users.id = peminjaman.id_user')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->where('id_peminjaman', $idPeminjaman)
            ->get()->getRowArray();

        $namaUser = $peminjaman['nama'];
        $judulBuku = $peminjaman['judul'];
        $totalDenda = number_format($peminjaman['denda'], 0, ',', '.');
        $telp = $peminjaman['telepon'];

        // Template Pesan WA
        $pesan = "Halo *{$namaUser}*,\n\nKami dari *DigiLibree* ingin menginfokan bahwa buku berjudul _'{$judulBuku}'_ sudah melewati batas pengembalian.\n\nTotal denda Anda saat ini: *Rp {$totalDenda}*.\nMohon segera melakukan pengembalian dan pelunasan di loker perpustakaan. Terimakasih! 🙏";

        // Redirect ke API WhatsApp
        return redirect()->to("https://wa.me/{$telp}?text=" . urlencode($pesan));
    }
}