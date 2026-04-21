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
        // 1. Ambil data peminjaman
        $pinjam = $this->pinjamModel->find($id);
        
        // Cek apakah datanya ada
        if (!$pinjam) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan!');
        }

        // 2. Proteksi: Pastikan hanya User yang meminjam buku ini yang bisa mengembalikan
        // (Biar user lain gak iseng balikin buku orang lain)
        if (session()->get('role') != 'admin' && $pinjam['id_user'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Eits, kamu gak berhak mengembalikan buku ini! 👮');
        }

        $buku = $this->bukuModel->find($pinjam['id_buku']);
        
        // 3. Hitung denda jika terlambat (Rp 2.000 / hari)
        $tgl_kembali = new \DateTime($pinjam['tanggal_kembali']);
        $tgl_sekarang = new \DateTime(date('Y-m-d'));
        $denda = 0;

        if ($tgl_sekarang > $tgl_kembali) {
            $denda = $tgl_sekarang->diff($tgl_kembali)->days * 2000;
        }

        // 4. Update status pinjam jadi 'kembali'
        $updateStatus = $this->pinjamModel->update($id, [
            'status' => 'kembali',
            'tanggal_pengembalian_asli' => date('Y-m-d'),
            'denda'  => $denda
        ]);

        if ($updateStatus) {
            // 5. Balikin stok buku (+1)
            $this->bukuModel->update($pinjam['id_buku'], [
                'tersedia' => $buku['tersedia'] + 1
            ]);
            
            $this->catatLog('Pengembalian Buku', 'User mengembalikan buku: ' . $buku['judul']);

            return redirect()->to('/peminjaman')->with('success', 'Buku berhasil dikembalikan! ' . ($denda > 0 ? 'Denda kamu: Rp ' . number_format($denda, 0, ',', '.') : 'Tepat waktu, mantap!'));
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


}