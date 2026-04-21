<?php

namespace App\Controllers;

use App\Models\LogModel;
use Config\Database; // <-- Wajib ada untuk memanggil Database konektor

class Log extends BaseController
{
    protected $logModel;
    protected $db; // <-- Siapkan variabel db di tingkat class

    public function __construct()
    {
        $this->logModel = new LogModel();
        $this->db = Database::connect(); // <-- Inisialisasi koneksi db di sini
    }

    public function index()
    {
        // Pastikan nama tabel di join ('users') dan kolom ID sesuai dengan database kamu
        $data['log_aktivitas'] = $this->logModel->select('log_aktivitas.*, users.username')
                                       ->join('users', 'users.id = log_aktivitas.id_user', 'left')
                                       ->orderBy('log_aktivitas.created_at', 'DESC')
                                       ->findAll();

        return view('log/index', $data);
    }

    // Fungsi untuk mencatat aktivitas baru
    public function saveLog($aksi, $keterangan)
    {
        // Pastikan di session kamu menggunakan key 'id_user' atau 'id'
        $this->logModel->save([
            'id_user'    => session()->get('id_user') ?? session()->get('id'), 
            'aksi'       => $aksi,
            'keterangan' => $keterangan,
            'ip_address' => $this->request->getIPAddress(),
        ]);
    }

    // Hapus satu per satu
    public function delete($id)
    {
        $this->logModel->delete($id);
        return redirect()->to('/log')->with('success', 'Satu baris log berhasil dihapus.');
    }

    // Hapus semua log sekaligus (TRUNCATE)
    public function clear()
    {
        // Gunakan nama tabel yang benar di database (misal: log_aktivitas)
        $this->db->table('log_aktivitas')->truncate(); 
        return redirect()->to('/log')->with('success', 'Semua log aktivitas telah dibersihkan.');
    }
}