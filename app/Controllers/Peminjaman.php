<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use App\Models\UsersModel; 
use App\Models\LogModel;

class Peminjaman extends BaseController
{
    protected $pinjamModel;
    protected $bukuModel;
    protected $userModel;
    protected $logModel;

    public function __construct()
    {
        $this->pinjamModel = new PeminjamanModel();
        $this->bukuModel   = new BukuModel();
        $this->userModel   = new UsersModel();
        $this->logModel    = new LogModel();
    }

    /**
     * Helper: Mencatat log aktivitas sistem
     */
    private function catatLog($aksi, $keterangan)
    {
        $this->logModel->save([
            // Memastikan id_user diambil dari session, default ke 1 jika gagal
            'id_user'    => session()->get('id_user') ?? 1,
            'aksi'       => $aksi,
            'keterangan' => $keterangan,
            'ip_address' => $this->request->getIPAddress(),
        ]);
    }

    // --- READ & SEARCH (Tampilan Utama) ---
    // --- READ & SEARCH (Tampilan Utama) ---
    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $role    = session()->get('role');
        $userId  = session()->get('id');

        // Mulai membangun query agar tidak menulis join berulang-ulang
        $query = $this->pinjamModel->select('peminjaman.*, buku.judul, buku.id_penulis, users.username, users.telepon')
                                    ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                                    ->join('users', 'users.id = peminjaman.id_user');

        if ($role == 'admin') {
            // Admin: Melihat semua transaksi
            if ($keyword) {
                $query->groupStart()
                      ->like('buku.judul', $keyword)
                      ->orLike('users.username', $keyword)
                      ->groupEnd();
            }
        } else {
            // User/Anggota: Hanya melihat milik sendiri
            $query->where('peminjaman.id_user', $userId);
            
            if ($keyword) {
                $query->like('buku.judul', $keyword);
            }
        }

        $peminjaman = $query->orderBy('peminjaman.id_peminjaman', 'DESC')->findAll();

        $data = [
            'title'      => 'Aktivitas Pinjam Buku',
            'keyword'    => $keyword,
            'peminjaman' => $peminjaman
        ];
        
        return view('peminjaman/index', $data);
    }

    // --- FITUR UNGGULAN: PINJAM KILAT (User Only) ---
    public function pinjamKilat($id_buku)
{
    $userId = session()->get('id');
    if (!$userId) {
        return redirect()->to('/login')->with('error', 'Eh, login dulu yuk! 😊');
    }

    if (session()->get('role') == 'admin') {
        return redirect()->back()->with('error', 'Admin gak perlu pinjam! 😎');
    }

    $buku = $this->bukuModel->find($id_buku);
    if (!$buku || $buku['tersedia'] <= 0) {
        return redirect()->back()->with('error', 'Yah, stok buku abis! 🙏');
    }

    // --- LOGIKA LIMIT PEMINJAMAN ---
    $limit_otomatis = 3; // Jatah pinjam tanpa izin admin
    
    // Hitung buku yang sedang dipinjam (status 'dipinjam' atau 'disetujui')
    $jumlah_aktif = $this->pinjamModel->where('id_user', $userId)
                                      ->whereIn('status', ['dipinjam', 'disetujui'])
                                      ->countAllResults();

    // Tentukan status awal
    if ($jumlah_aktif >= $limit_otomatis) {
        $status_baru = 'pending';
        $pesan_sukses = 'Kuota pinjam penuh! Pengajuanmu sudah dikirim ke Admin untuk verifikasi ya. 😉';
    } else {
        $status_baru = 'disetujui'; // Atau 'dipinjam' sesuai enum kamu
        $pesan_sukses = 'Berhasil dipinjam! Jaga bukunya baik-baik ya.';
    }

    $data = [
        'id_user'         => $userId,
        'id_buku'         => $id_buku,
        'tanggal_pinjam'  => date('Y-m-d'),
        'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
        'status'          => $status_baru,
        'denda'           => 0
    ];

    if ($this->pinjamModel->insert($data)) {
        // Stok hanya berkurang kalau statusnya langsung 'disetujui'
        if ($status_baru == 'disetujui') {
            $this->bukuModel->update($id_buku, ['tersedia' => $buku['tersedia'] - 1]);
        }
        
        $this->catatLog('Pinjam Buku', "User mengajukan pinjam: {$buku['judul']} (Status: $status_baru)");
        return redirect()->to('/peminjaman')->with('success', $pesan_sukses);
    }

    return redirect()->back()->with('error', 'Gagal simpan data.');
}
    // --- PROSES PENGEMBALIAN (Sekarang Bisa dilakukan oleh User) ---
   public function kembalikan($id)
{
    $pinjam = $this->pinjamModel->find($id);
    
    if (!$pinjam) {
        return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan!');
    }

    if (session()->get('role') != 'admin' && $pinjam['id_user'] != session()->get('id')) {
        return redirect()->back()->with('error', 'Eits, kamu gak berhak mengembalikan buku ini! 👮');
    }

    $buku = $this->bukuModel->find($pinjam['id_buku']);
    
    // --- HITUNG DENDA ---
    $tgl_kembali = new \DateTime($pinjam['tanggal_kembali']);
    $tgl_sekarang = new \DateTime(date('Y-m-d'));
    $denda = 0;
    $status_denda = 'tidak_ada'; // Default jika tepat waktu

    if ($tgl_sekarang > $tgl_kembali) {
        $selisih = $tgl_sekarang->diff($tgl_kembali)->days;
        $denda = $selisih * 2000;
        $status_denda = 'belum_bayar'; // SET STATUS INI!
    }

    // --- UPDATE DATA ---
    $updateStatus = $this->pinjamModel->update($id, [
        'status' => 'kembali',
        'tanggal_pengembalian_asli' => date('Y-m-d'),
        'denda' => $denda,
        'status_denda' => $status_denda // Tambahkan baris ini
    ]);

    if ($updateStatus) {
        $this->bukuModel->update($pinjam['id_buku'], [
            'tersedia' => $buku['tersedia'] + 1
        ]);
        
        $this->catatLog('Pengembalian Buku', 'Buku dikembalikan: ' . $buku['judul'] . ($denda > 0 ? ' dengan denda Rp'.$denda : ''));

        $pesan = ($denda > 0) 
            ? "Buku kembali! Kamu telat nih, dendanya Rp " . number_format($denda, 0, ',', '.') . ". Segera bayar ya!" 
            : "Buku kembali tepat waktu! Kamu hebat! 🌟";

        return redirect()->to('/peminjaman')->with('success', $pesan);
    }

    return redirect()->back()->with('error', 'Gagal memproses pengembalian.');
}
    public function riwayat()
{
    $userId = session()->get('id');
    
    // Ambil data peminjaman milik user ini saja
    $data['riwayat'] = $this->pinjamModel->select('peminjaman.*, buku.judul, buku.cover')
                        ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                        ->where('peminjaman.id_user', $userId)
                        ->orderBy('peminjaman.id_peminjaman', 'DESC')
                        ->findAll();
    
    $data['title'] = "Riwayat Membaca Saya";
    return view('peminjaman/riwayat', $data);
}
// --- KHUSUS ADMIN: ACC PEMINJAMAN OVER-LIMIT ---
public function persetujuan()
{
    if (session()->get('role') != 'admin') return redirect()->to('/');

    $data = [
        'title'    => 'Persetujuan Peminjaman',
        'requests' => $this->pinjamModel->select('peminjaman.*, buku.judul, users.username as nama')
                        ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                        ->join('users', 'users.id = peminjaman.id_user')
                        ->where('peminjaman.status', 'pending')
                        ->findAll()
    ];

    return view('peminjaman/persetujuan', $data);
}

public function approve($id)
{
    $pinjam = $this->pinjamModel->find($id);
    $buku   = $this->bukuModel->find($pinjam['id_buku']);

    if ($buku['tersedia'] > 0) {
        $this->pinjamModel->update($id, ['status' => 'disetujui']);
        $this->bukuModel->update($pinjam['id_buku'], ['tersedia' => $buku['tersedia'] - 1]);
        return redirect()->back()->with('success', 'Peminjaman di-acc! Stok buku berkurang.');
    }

    return redirect()->back()->with('error', 'Gagal! Stok buku mendadak habis.');
}

public function reject($id)
{
    $this->pinjamModel->update($id, ['status' => 'ditolak']);
    return redirect()->back()->with('success', 'Permintaan pinjam ditolak.');
}
public function proses_kembali($id_peminjaman)
{
    $pinjam = $this->db->table('peminjaman')->where('id_peminjaman', $id_peminjaman)->get()->getRowArray();
    
    $tgl_kembali = new \DateTime($pinjam['tanggal_kembali']);
    $tgl_sekarang = new \DateTime(date('Y-m-d'));
    
    $denda = 0;
    $status_denda = 'tidak_ada';

    // Jika telat
    if ($tgl_sekarang > $tgl_kembali) {
        $selisih = $tgl_sekarang->diff($tgl_kembali)->days;
        $denda = $selisih * 2000; // Contoh: 2rb per hari
        $status_denda = 'belum_bayar';
    }

    $this->db->table('peminjaman')->where('id_peminjaman', $id_peminjaman)->update([
        'tanggal_pengembalian_asli' => date('Y-m-d'),
        'status'       => 'kembali',
        'denda'        => $denda,
        'status_denda' => $status_denda
    ]);

    return redirect()->back()->with('success', 'Buku kembali! Denda: Rp ' . number_format($denda));
}
public function lunas_denda($id)
{
    $this->db->table('peminjaman')->where('id_peminjaman', $id)->update(['status_denda' => 'lunas']);
    return redirect()->back()->with('success', 'Denda telah dibayar tunai! ✅');
}
// FUNGSI UNTUK USER: Lapor sudah bayar
public function konfirmasi_bayar($id) {
    // Kita ubah status_denda jadi 'proses' (atau tetap 'belum_bayar' tapi kasih penanda)
    // Di sini saya kasih contoh update status denda agar admin tahu
    $this->db->table('peminjaman')->where('id_peminjaman', $id)->update([
        'status_denda' => 'proses' // Pastikan enum di DB ada 'proses'
    ]);
    return redirect()->back()->with('success', 'Laporan pembayaran terkirim! Admin akan segera mengecek.');
}

// FUNGSI UNTUK ADMIN: Tekan tombol lunas
public function lunas($id) {
    $this->db->table('peminjaman')->where('id_peminjaman', $id)->update([
        'status_denda' => 'lunas',
        'denda'        => 0 // Opsional: nol-kan angka denda setelah lunas
    ]);
    return redirect()->back()->with('success', 'Status denda berhasil diubah menjadi LUNAS! ✅');
}
public function simpanUlasan()
{
    // Pastikan user login
    $id_user = session()->get('id');
    if (!$id_user) return redirect()->to('/login');

    $db = \Config\Database::connect();
    
    // Simpan ke tabel ulasan (pastikan kamu sudah buat tabelnya di DB)
    $db->table('ulasan')->insert([
        'id_user'  => $id_user,
        'id_buku'  => $this->request->getPost('id_buku'),
        'rating'   => $this->request->getPost('rating'),
        'komentar' => $this->request->getPost('komentar'),
        'created_at' => date('Y-m-d H:i:s')
    ]);

    return redirect()->to('/peminjaman')->with('success', 'Terima kasih! Ulasan kamu sangat berarti bagi pembaca lain. ⭐');
}

}