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

    /**
     * TAMPILAN KATALOG UTAMA
     * Diurutkan berdasarkan jumlah peminjaman terbanyak (Terpopuler)
     */
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->db->table('buku');
        $builder->select('
            buku.*,
            kategori.nama_kategori,
            penulis.nama_penulis,
            penerbit.nama_penerbit,
            rak.nama_rak,
            rak.lokasi,
            (SELECT COUNT(id_peminjaman) FROM peminjaman WHERE peminjaman.id_buku = buku.id_buku) as total_dipinjam
        ');
        $builder->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');
        $builder->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left');
        $builder->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left');
        $builder->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left');
        $builder->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');

        if ($keyword) {
            $builder->groupStart()
                    ->like('buku.judul', $keyword)
                    ->orLike('penulis.nama_penulis', $keyword)
                    ->groupEnd();
        }

        // --- FITUR TERPOPULER ---
        // Buku yang paling banyak dipinjam akan naik ke atas
        $builder->orderBy('total_dipinjam', 'DESC');

        $data = [
            'title'   => 'Koleksi Buku | DigiLibree',
            'buku'    => $builder->get()->getResultArray(),
            'keyword' => $keyword
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
        // Validasi sederhana (Optional tapi disarankan)
        $dataBuku = [
            'judul'       => $this->request->getPost('judul'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'id_penulis'  => $this->request->getPost('id_penulis'),
            'id_penerbit' => $this->request->getPost('id_penerbit'),
            'tahun_terbit'=> $this->request->getPost('tahun_terbit'),
            'tersedia'    => $this->request->getPost('tersedia'),
        ];

        $this->buku->insert($dataBuku);
        $id_buku = $this->buku->getInsertID();

        // Masukkan data ke tabel relasi buku_rak
        $this->db->table('buku_rak')->insert([
            'id_buku' => $id_buku,
            'id_rak'  => $this->request->getPost('id_rak')
        ]);

        return redirect()->to('/buku')->with('success', 'Buku baru berhasil ditambahkan! 📚');
    }

    public function detail($id)
    {
        $builder = $this->db->table('buku');
        $builder->select('
            buku.*, 
            kategori.nama_kategori, 
            penulis.nama_penulis, 
            penerbit.nama_penerbit, 
            rak.nama_rak, 
            rak.lokasi as lokasi_rak,
            (SELECT COUNT(id_peminjaman) FROM peminjaman WHERE peminjaman.id_buku = buku.id_buku) as total_dipinjam
        ');
        $builder->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');
        $builder->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left');
        $builder->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left');
        $builder->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left');
        $builder->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');
        $builder->where('buku.id_buku', $id);
        
        $buku = $builder->get()->getRowArray();

        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail: ' . $buku['judul'],
            'buku'  => $buku
        ];

        return view('buku/detail', $data);
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Edit Data Buku',
            'buku'     => $this->buku->find($id),
            'kategori' => $this->db->table('kategori')->get()->getResultArray(),
            'penulis'  => $this->db->table('penulis')->get()->getResultArray(),
            'penerbit' => $this->db->table('penerbit')->get()->getResultArray(),
            'rak'      => $this->db->table('rak')->get()->getResultArray(),
        ];

        // Ambil ID Rak saat ini dari tabel relasi
        $currentRak = $this->db->table('buku_rak')->where('id_buku', $id)->get()->getRowArray();
        $data['current_rak'] = $currentRak ? $currentRak['id_rak'] : '';

        return view('buku/edit', $data);
    }

    public function update($id)
    {
        $dataPost = $this->request->getPost();

        // Update tabel buku
        $this->buku->update($id, [
            'judul'       => $dataPost['judul'],
            'id_kategori' => $dataPost['id_kategori'],
            'id_penulis'  => $dataPost['id_penulis'],
            'id_penerbit' => $dataPost['id_penerbit'],
            'tahun_terbit'=> $dataPost['tahun_terbit'],
            'tersedia'    => $dataPost['tersedia'],
        ]);

        // Update atau Insert (jika belum ada) di tabel relasi buku_rak
        $cekRak = $this->db->table('buku_rak')->where('id_buku', $id)->get()->getRowArray();
        if ($cekRak) {
            $this->db->table('buku_rak')->where('id_buku', $id)->update(['id_rak' => $dataPost['id_rak']]);
        } else {
            $this->db->table('buku_rak')->insert(['id_buku' => $id, 'id_rak' => $dataPost['id_rak']]);
        }

        return redirect()->to('/buku')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Hapus relasi di buku_rak dulu baru hapus bukunya (foreign key safety)
        $this->db->table('buku_rak')->where('id_buku', $id)->delete();
        $this->buku->delete($id);
        
        return redirect()->to('/buku')->with('success', 'Buku telah dihapus dari koleksi.');
    }

    // --- HELPER UNTUK WHATSAPP ---
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