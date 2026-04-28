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
    protected $db; // Tambahkan properti db agar bisa dipakai di seluruh class

    public function __construct()
    {
        $this->pinjamModel = new PeminjamanModel();
        $this->bukuModel   = new BukuModel();
        $this->userModel   = new UsersModel();
        $this->logModel    = new LogModel();
        $this->db          = \Config\Database::connect(); // Koneksi sekali di sini
    }

    private function catatLog($aksi, $keterangan)
    {
        $this->logModel->save([
            'id_user'    => session()->get('id') ?? 1,
            'aksi'       => $aksi,
            'keterangan' => $keterangan,
            'ip_address' => $this->request->getIPAddress(),
        ]);
    }

    // --- Tampilan Utama ---
    public function index()
{
    $id_user = session()->get('id');
    $role = session()->get('role');
    $keyword = $this->request->getVar('keyword');

    $builder = $this->db->table('peminjaman');
    $builder->select('peminjaman.*, buku.judul, users.username, users.telepon, ulasan.id_ulasan'); // Tambah users.no_hp buat WA
    $builder->join('buku', 'buku.id_buku = peminjaman.id_buku');
    $builder->join('users', 'users.id = peminjaman.id_user');
    $builder->join('ulasan', 'ulasan.id_peminjaman = peminjaman.id_peminjaman', 'left');

    if ($role != 'admin') {
        $builder->where('peminjaman.id_user', $id_user);
    }

    if ($keyword) {
        $builder->groupStart()
                ->like('buku.judul', $keyword)
                ->orLike('users.username', $keyword)
                ->groupEnd();
    }

    $peminjaman = $builder->orderBy('peminjaman.id_peminjaman', 'DESC')->get()->getResultArray();

    // --- LOGIKA DENDA OTOMATIS (REAL-TIME) ---
    foreach ($peminjaman as &$p) {
        // Jika masih dipinjam, hitung denda telat sementara
        if ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') {
            $tgl_kembali = new \DateTime($p['tanggal_kembali']);
            $tgl_sekarang = new \DateTime(date('Y-m-d'));

            if ($tgl_sekarang > $tgl_kembali) {
                $selisih = $tgl_sekarang->diff($tgl_kembali)->days;
                $denda_telat = $selisih * 2000; // Contoh: 2rb/hari
                
                // Update ke database agar User & Admin lihat nominal yang sama
                $this->pinjamModel->update($p['id_peminjaman'], [
                    'denda' => $denda_telat,
                    'status_denda' => ($p['status_denda'] == 'lunas') ? 'lunas' : 'belum_bayar'
                ]);
                
                $p['denda'] = $denda_telat; // Update tampilan array
            }
        }
    }

    $data = [
        'peminjaman' => $peminjaman,
        'keyword'    => $keyword
    ];

    return view('peminjaman/index', $data);
}

    public function pinjamKilat($id_buku)
    {
        $userId = session()->get('id');
        if (!$userId) return redirect()->to('/login')->with('error', 'Login dulu yuk! 😊');
        if (session()->get('role') == 'admin') return redirect()->back()->with('error', 'Admin gak perlu pinjam!');

        $buku = $this->bukuModel->find($id_buku);
        if (!$buku || $buku['tersedia'] <= 0) return redirect()->back()->with('error', 'Stok buku abis!');

        $jumlah_aktif = $this->pinjamModel->where('id_user', $userId)
                                          ->whereIn('status', ['dipinjam', 'disetujui'])
                                          ->countAllResults();

        $status_baru = ($jumlah_aktif >= 3) ? 'pending' : 'disetujui';
        $pesan_sukses = ($status_baru == 'pending') ? 'Kuota penuh, tunggu ACC admin ya!' : 'Berhasil dipinjam!';

        $data = [
            'id_user'         => $userId,
            'id_buku'         => $id_buku,
            'tanggal_pinjam'  => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status'          => $status_baru,
            'denda'           => 0
        ];

        if ($this->pinjamModel->insert($data)) {
            if ($status_baru == 'disetujui') {
                $this->bukuModel->update($id_buku, ['tersedia' => $buku['tersedia'] - 1]);
            }
            $this->catatLog('Pinjam Buku', "Meminjam {$buku['judul']}");
            return redirect()->to('/peminjaman')->with('success', $pesan_sukses);
        }
    }

    public function kembalikan($id)
    {
        $pinjam = $this->pinjamModel->find($id);
        if (!$pinjam || $pinjam['status'] == 'kembali') return redirect()->back();

        $buku = $this->bukuModel->find($pinjam['id_buku']);
        
        // Hitung Denda
        $tgl_kembali = new \DateTime($pinjam['tanggal_kembali']);
        $tgl_sekarang = new \DateTime(date('Y-m-d'));
        $denda = 0;
        $status_denda = 'tidak_ada'; 

        if ($tgl_sekarang > $tgl_kembali) {
            $selisih = $tgl_sekarang->diff($tgl_kembali)->days;
            $denda = $selisih * 2000; 
            $status_denda = 'belum_bayar'; 
        }

        $dataUpdate = [
            'status' => 'kembali',
            'tanggal_pengembalian_asli' => date('Y-m-d'),
            'denda' => $denda,
            'status_denda' => $status_denda 
        ];

        if ($this->pinjamModel->update($id, $dataUpdate)) {
            $this->bukuModel->update($pinjam['id_buku'], ['tersedia' => $buku['tersedia'] + 1]);
            $this->catatLog('Pengembalian', "Buku {$buku['judul']} kembali");
            return redirect()->to('/peminjaman')->with('success', "Buku dikembalikan!");
        }
    }

    public function persetujuan()
    {
        if (session()->get('role') != 'admin') return redirect()->to('/');
        $data['requests'] = $this->pinjamModel->select('peminjaman.*, buku.judul, users.username as nama')
                                ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                                ->join('users', 'users.id = peminjaman.id_user')
                                ->where('peminjaman.status', 'pending')
                                ->findAll();
        return view('peminjaman/persetujuan', $data);
    }

    public function approve($id)
    {
        $pinjam = $this->pinjamModel->find($id);
        $buku   = $this->bukuModel->find($pinjam['id_buku']);
        if ($buku['tersedia'] > 0) {
            $this->pinjamModel->update($id, ['status' => 'disetujui']);
            $this->bukuModel->update($pinjam['id_buku'], ['tersedia' => $buku['tersedia'] - 1]);
            return redirect()->back()->with('success', 'Disetujui!');
        }
        return redirect()->back()->with('error', 'Stok habis!');
    }

    public function reject($id)
    {
        $this->pinjamModel->update($id, ['status' => 'ditolak']);
        return redirect()->back()->with('success', 'Ditolak!');
    }

    public function lunas($id)
    {
        $this->db->table('peminjaman')->where('id_peminjaman', $id)->update(['status_denda' => 'lunas']);
        return redirect()->back()->with('success', 'Lunas! ✅');
    }

    public function simpanUlasan()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');
        $cek = $this->db->table('ulasan')->where('id_peminjaman', $id_peminjaman)->get()->getRow();

        if ($cek) return redirect()->back()->with('error', 'Sudah pernah diulas!');

        $data = [
            'id_user'       => session()->get('id'),
            'id_buku'       => $this->request->getPost('id_buku'),
            'id_peminjaman' => $id_peminjaman,
            'rating'        => $this->request->getPost('rating'),
            'komentar'      => $this->request->getPost('komentar'),
        ];

        $this->db->table('ulasan')->insert($data);
        return redirect()->back()->with('success', 'Terima kasih atas ulasannya!');
    }
    public function riwayat()
{
    $userId = session()->get('id');
    
    $data = [
        'title'   => "Riwayat Membaca Saya",
        'riwayat' => $this->pinjamModel->select('peminjaman.*, buku.judul, buku.cover, buku.file_pdf') // <-- TAMBAHKAN buku.file_pdf DI SINI
                        ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                        ->where('peminjaman.id_user', $userId)
                        ->whereIn('peminjaman.status', ['kembali', 'ditolak'])
                        ->orderBy('peminjaman.id_peminjaman', 'DESC')
                        ->findAll()
    ];
    
    return view('peminjaman/riwayat', $data);
}
public function tambahDenda($id) {
    $peminjamanModel = new \App\Models\PeminjamanModel();
    
    // Admin input nominal (misal 50.000 karena buku robek)
    $nominal = $this->request->getPost('nominal_denda');
    $alasan  = $this->request->getPost('catatan');

    $peminjamanModel->update($id, [
        'denda'   => $nominal, 
        'catatan' => $alasan
    ]);

    return redirect()->back()->with('success', 'Denda berhasil ditetapkan.');
}
public function selesaikan_tanpa_denda($id)
{
    $this->peminjamanModel->update($id, [
        'status_denda' => 'lunas', // Dianggap lunas karena denda 0
        'tanggal_selesai' => date('Y-m-d H:i:s'),
        'catatan' => 'Buku kembali dalam kondisi baik.'
    ]);

    return redirect()->back()->with('success', 'Transaksi diselesaikan!');
}
public function set_denda_manual($id)
{
    if (session()->get('role') != 'admin') return redirect()->to('/')->with('error', 'Akses ditolak!');

    $pinjam = $this->pinjamModel->find($id);
    $nominal_tambahan = $this->request->getPost('nominal_denda'); // Inputan Admin (misal denda rusak)
    $catatan = $this->request->getPost('catatan');

    // Denda total adalah denda telat yang sudah tercatat + nominal tambahan dari admin
    $denda_total = $pinjam['denda'] + $nominal_tambahan;

    $this->pinjamModel->update($id, [
        'denda'        => $denda_total,
        'catatan'      => $catatan,
        'status_denda' => ($denda_total > 0) ? 'belum_bayar' : 'lunas'
    ]);

    return redirect()->back()->with('success', 'Denda fisik berhasil ditambahkan!');
}
public function bayar_denda($id)
{
    $file = $this->request->getFile('bukti_bayar');

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $namaFile = $file->getRandomName();
        
        // FCPATH itu mengarah ke folder 'public'
        // Jadi file akan masuk ke: public/bukti_bayar/
        $file->move(FCPATH . 'bukti_bayar', $namaFile); 

        $this->pinjamModel->update($id, [
            'bukti_bayar'  => $namaFile,
            'status_denda' => 'proses'
        ]);

        return redirect()->back()->with('success', 'Bukti terkirim!');
    }
    
    return redirect()->back()->with('error', 'Gagal upload.');
}
}