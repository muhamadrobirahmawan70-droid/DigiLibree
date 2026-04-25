<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    protected $buku;
    protected $db;

    public function __construct()
    {
        $this->buku = new BukuModel();
        $this->db = \Config\Database::connect();
    }

   public function index()
{
    $keyword = $this->request->getGet('keyword');
    $sort    = $this->request->getGet('sort');

    // 1. Ambil Semua Kategori untuk Header Rak
    $kategori = $this->db->table('kategori')->get()->getResultArray();

    // 2. Build Query Buku (Sama seperti punya kamu)
    $builder = $this->db->table('buku');
    $builder->select('
        buku.*,
        kategori.nama_kategori,
        penulis.nama_penulis,
        penerbit.nama_penerbit,
        rak.nama_rak,
        rak.lokasi,
        (SELECT COUNT(id_peminjaman) FROM peminjaman WHERE peminjaman.id_buku = buku.id_buku) as total_dipinjam,
        (SELECT AVG(rating) FROM ulasan WHERE ulasan.id_buku = buku.id_buku) as rata_rating,
        (SELECT COUNT(id_ulasan) FROM ulasan WHERE ulasan.id_buku = buku.id_buku) as total_ulasan
    ');
    $builder->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');
    $builder->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left');
    $builder->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left');
    $builder->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left');
    $builder->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');
    $builder->groupBy('buku.id_buku');
    if ($keyword) {
        $builder->groupStart()
                ->like('buku.judul', $keyword)
                ->orLike('penulis.nama_penulis', $keyword)
                ->groupEnd();
    }

    if ($sort == 'rating') {
        $builder->orderBy('rata_rating', 'DESC');
    } elseif ($sort == 'populer') {
        $builder->orderBy('total_dipinjam', 'DESC');
    } else {
        $builder->orderBy('buku.id_buku', 'DESC');
    }

    $data = [
        'title'    => 'Koleksi Buku | DigiLibree',
        'buku'     => $builder->get()->getResultArray(),
        'kategori' => $kategori, // Tambahkan ini
        'keyword'  => $keyword,
        'sort'     => $sort
    ];

    return view('buku/index', $data);
}

    public function create()
    {
        $data = [
            'title'    => 'Tambah Buku Baru',
            'kategori' => $this->db->table('kategori')->get()->getResultArray(),
            'penulis'  => $this->db->table('penulis')->get()->getResultArray(),
            'penerbit' => $this->db->table('penerbit')->get()->getResultArray(),
            'rak'      => $this->db->table('rak')->get()->getResultArray(),
        ];

        return view('buku/create', $data);
    }

    public function store()
    {
        $fileCover = $this->request->getFile('cover');
        $namaCover = 'default.jpg';

        if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
            $namaCover = $fileCover->getRandomName();
            $fileCover->move('uploads/buku/cover', $namaCover);
        }

        $dataBuku = [
            'judul'       => $this->request->getPost('judul'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'id_penulis'  => $this->request->getPost('id_penulis'),
            'id_penerbit' => $this->request->getPost('id_penerbit'),
            'tahun_terbit'=> $this->request->getPost('tahun_terbit'),
            'tersedia'    => $this->request->getPost('tersedia'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'cover'       => $namaCover,
        ];

        $this->buku->insert($dataBuku);
        $id_buku = $this->buku->getInsertID();

        $this->db->table('buku_rak')->insert([
            'id_buku' => $id_buku,
            'id_rak'  => $this->request->getPost('id_rak')
        ]);

        return redirect()->to('/buku')->with('success', 'Buku baru berhasil ditambahkan! 📚');
    }

    public function detail($id)
    {
        $buku = $this->db->table('buku')
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak,
                      (SELECT AVG(rating) FROM ulasan WHERE ulasan.id_buku = buku.id_buku) as rata_rating,
                      (SELECT COUNT(id_ulasan) FROM ulasan WHERE ulasan.id_buku = buku.id_buku) as total_ulasan,
                      (SELECT COUNT(id_peminjaman) FROM peminjaman WHERE peminjaman.id_buku = buku.id_buku) as total_dipinjam')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
            ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left')
            ->where('buku.id_buku', $id)
            ->get()->getRowArray();

        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Buku | ' . $buku['judul'],
            'buku'  => $buku
        ];

        return view('buku/detail', $data);
    }

    public function edit($id)
    {
        $buku = $this->buku->find($id);
        if (!$buku) return redirect()->to('/buku');

        $data = [
            'title'    => 'Edit Data Buku',
            'buku'     => $buku,
            'kategori' => $this->db->table('kategori')->get()->getResultArray(),
            'penulis'  => $this->db->table('penulis')->get()->getResultArray(),
            'penerbit' => $this->db->table('penerbit')->get()->getResultArray(),
            'rak'      => $this->db->table('rak')->get()->getResultArray(),
        ];

        $currentRak = $this->db->table('buku_rak')->where('id_buku', $id)->get()->getRowArray();
        $data['current_rak'] = $currentRak ? $currentRak['id_rak'] : '';

        return view('buku/edit', $data);
    }

    public function update($id)
    {
        $bukuLama = $this->buku->find($id);
        $fileCover = $this->request->getFile('cover');
        $namaCover = $bukuLama['cover'];

        if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
            $namaCover = $fileCover->getRandomName();
            $fileCover->move('uploads/buku/cover', $namaCover);
            
            if ($bukuLama['cover'] != 'default.jpg' && !empty($bukuLama['cover'])) {
                $pathLama = FCPATH . 'uploads/buku/cover/' . $bukuLama['cover'];
                if (file_exists($pathLama)) {
                    unlink($pathLama);
                }
            }
        }

        $this->buku->update($id, [
            'judul'       => $this->request->getPost('judul'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'id_penulis'  => $this->request->getPost('id_penulis'),
            'id_penerbit' => $this->request->getPost('id_penerbit'),
            'tahun_terbit'=> $this->request->getPost('tahun_terbit'),
            'tersedia'    => $this->request->getPost('tersedia') ?? 0,
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'cover'       => $namaCover,
        ]);

        $cekRak = $this->db->table('buku_rak')->where('id_buku', $id)->get()->getRowArray();
        if ($cekRak) {
            $this->db->table('buku_rak')->where('id_buku', $id)->update(['id_rak' => $this->request->getPost('id_rak')]);
        } else {
            $this->db->table('buku_rak')->insert(['id_buku' => $id, 'id_rak' => $this->request->getPost('id_rak')]);
        }

        return redirect()->to('/buku')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function delete($id)
    {
        $buku = $this->buku->find($id);
        
        if ($buku && $buku['cover'] != 'default.jpg' && !empty($buku['cover'])) {
            $pathFile = FCPATH . 'uploads/buku/cover/' . $buku['cover'];
            if (file_exists($pathFile)) {
                unlink($pathFile);
            }
        }

        $this->db->table('buku_rak')->where('id_buku', $id)->delete();
        $this->buku->delete($id);
        
        return redirect()->to('/buku')->with('success', 'Buku telah dihapus.');
    }

    public function wa($id)
    {
        $buku = $this->detailData($id);
        if (!$buku) return redirect()->back();

        $pesan = "*DIGILIBREE - INFO BUKU*\n\n";
        $pesan .= "📖 *Judul:* " . $buku['judul'] . "\n";
        $pesan .= "✍️ *Penulis:* " . ($buku['nama_penulis'] ?? '-') . "\n";
        $pesan .= "📂 *Kategori:* " . ($buku['nama_kategori'] ?? '-') . "\n";
        $pesan .= "🏢 *Penerbit:* " . ($buku['nama_penerbit'] ?? '-') . "\n";
        $pesan .= "📦 *Stok:* " . $buku['tersedia'] . " Eks\n";
        $pesan .= "\n_Tertarik meminjam? Yuk ke DigiLibree sekarang!_";

        return redirect()->to("https://wa.me/6285175017991?text=" . urlencode($pesan));
    }

    private function detailData($id)
    {
        return $this->db->table('buku')
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->where('buku.id_buku', $id)
            ->get()->getRowArray();
    }
}