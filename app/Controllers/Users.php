<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        // Validasi form
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama'     => 'required',
            'email'    => 'required|valid_email',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[4]',
            'role'     => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', implode('<br>', $validation->getErrors()));
        }

        // ============== Upload Foto ==============
        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/users', $namaFoto);
        }

        // ============== Simpan Data ==============
        $this->users->save([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
            'foto'     => $namaFoto
        ]);

        return redirect()->to('/login')->with('success', 'User berhasil ditambahkan!');
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');

        $builder = $this->users;

        if ($keyword) {
            $builder = $builder->like('nama', $keyword);
        }

        if ($role) {
            $builder = $builder->where('role', $role);
        }

        $data['users'] = $builder->paginate(10);
        $data['pager'] = $this->users->pager;

        return view('users/index', $data);
    }

    public function edit($id)
    {
        $data['user'] = $this->users->find($id);
        return view('users/edit', $data);
    }

    public function update($id)
{
    // 1. Ambil data user lama dari database
    $userLama = $this->users->find($id);

    if (!$userLama) {
        return redirect()->back()->with('error', 'User tidak ditemukan.');
    }

    // 2. Olah Foto
    $fotoBaru = $this->request->getFile('foto');
    $namaFoto = $userLama['foto']; // Default pakai foto lama

    if ($fotoBaru && $fotoBaru->isValid() && !$fotoBaru->hasMoved()) {
        // Hapus foto lama jika ada dan filenya beneran ada di folder
        if (!empty($userLama['foto']) && file_exists(FCPATH . 'uploads/users/' . $userLama['foto'])) {
            unlink(FCPATH . 'uploads/users/' . $userLama['foto']);
        }

        // Simpan foto baru
        $namaFoto = $fotoBaru->getRandomName();
        $fotoBaru->move(FCPATH . 'uploads/users', $namaFoto);
    }

    // 3. Susun Data yang akan diupdate
    $data = [
        'nama'     => $this->request->getPost('nama'),
        'email'    => $this->request->getPost('email'),
        'username' => $this->request->getPost('username'),
        'foto'     => $namaFoto
    ];

    // --- PROTEKSI ROLE (TAMBAHAN) ---
    // Jika yang login bukan admin, maka role dipaksa tetap pakai role lama
    if (session()->get('role') != 'admin') {
        $data['role'] = $userLama['role']; 
    } else {
        // Jika admin, baru boleh ambil dari input form
        $data['role'] = $this->request->getPost('role');
    }

    // 4. Update Password jika diisi
    if ($this->request->getPost('password') != "") {
        $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
    }

    // 5. Eksekusi Update
    $this->users->update($id, $data);

    // --- SMART REDIRECT (TAMBAHAN) ---
    // ... setelah $this->users->update($id, $data);

if (session()->get('role') == 'admin') {
    return redirect()->to(base_url('users'))->with('success', 'Update Berhasil');
} else {
    // HARUS ADA ID-nya di ujung URL:
    return redirect()->to(base_url('users/detail/' . $id))->with('success', 'Profil diupdate');
}
}


    public function delete($id)
    {
        $user = $this->users->find($id);

        // hapus foto jika ada
        if ($user['foto'] && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
            unlink(FCPATH . 'uploads/users/' . $user['foto']);
        }

        $this->users->delete($id);

        return redirect()->to('/users')->with('success', 'User berhasil dihapus!');
        
    }    
    public function detail($id = null)
{
    // 1. Jika ID kosong (misal dipanggil dari tombol kembali yang salah), 
    // otomatis ambil ID dari user yang sedang login
    if ($id === null) {
        $id = session()->get('id');
    }

    // 2. Proteksi: Cegah user biasa ngintip profil orang lain
    if (session()->get('role') != 'admin' && session()->get('id') != $id) {
        return redirect()->to('/dashboard')->with('error', 'Kamu tidak punya akses ke profil tersebut.');
    }

    // 3. Cari datanya
    $user = $this->users->find($id);

    // 4. Jika data tidak ada di database
    if (!$user) {
        return redirect()->to('/users')->with('error', 'Data tidak ditemukan');
    }

    // 5. Kirim ke view (Hapus tanda "/" di akhir nama view)
    return view('users/detail', ['user' => $user]);
}
    public function print()
    {
        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');

        $builder = $this->users;

        if ($keyword) {
            $builder = $builder->like('nama', $keyword);
        }

        if ($role) {
            $builder = $builder->where('role', $role);
        }

        $data['users'] = $builder->findAll();

        return view('users/print', $data);
    }
    public function wa($id)
    {
        $user = $this->users->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // format pesan
        $pesan = "DATA USER\n\n";
        $pesan .= "ID: " . $user['id'] . "\n";
        $pesan .= "Nama: " . $user['nama'] . "\n";
        $pesan .= "Email: " . $user['email'] . "\n";
        $pesan .= "Username: " . $user['username'] . "\n";
        $pesan .= "Role: " . ucfirst($user['role']) . "\n";

        // encode URL
        $url = "https://wa.me/6285175017991?text=" . urlencode($pesan);

        return redirect()->to($url);
    }
}