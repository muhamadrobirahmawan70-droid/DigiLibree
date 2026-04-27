<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Styling khusus Berry User Page */
    .user-card-table {
        border: none;
        border-radius: 12px;
        background: #ffffff;
    }
    .berry-table thead th {
        background-color: #f8faff;
        color: #364152;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 15px 20px;
        border-bottom: 1px solid #e3e8ef;
    }
    .berry-table tbody td {
        padding: 18px 20px;
        border-bottom: 1px solid #f0f2f5;
        color: #364152;
        font-size: 0.875rem;
    }
    .img-user-list {
        width: 42px;
        height: 42px;
        border-radius: 10px; /* Berry suka border radius kotak yang tumpul, bukan bulat sempurna */
        object-fit: cover;
    }
    .search-filter-box {
        background: #ffffff;
        border: 1px solid #e3e8ef;
        border-radius: 12px;
        padding: 20px;
    }
    /* Badge Roles */
    .badge-berry {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.7rem;
    }
</style>

<div class="container-fluid">
    
    <div class="row mb-4 align-items-center">
        <div class="col-sm-6">
            <h3 class="fw-bold text-dark mb-1">Database Pengguna</h3>
            <p class="text-muted small">Kelola hak akses dan informasi pengguna sistem.</p>
        </div>
        <div class="col-sm-6 text-sm-end">
            <a href="<?= base_url('users/create') ?>" class="btn btn-purple-berry px-4 py-2" style="background: #673ab7; color: white; border-radius: 10px; font-weight: 600;">
                <i class="bi bi-person-plus-fill me-2"></i> Tambah User
            </a>
        </div>
    </div>

    <div class="search-filter-box mb-4 shadow-sm">
        <form method="get" action="" class="row g-3">
            <div class="col-md-5">
                <div class="input-group border rounded-3 overflow-hidden">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="keyword" class="form-control border-0 shadow-none" 
                           placeholder="Cari nama atau username..." value="<?= $_GET['keyword'] ?? '' ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select border rounded-3 shadow-none fw-semibold text-muted">
                    <option value="">Semua Hak Akses</option>
                    <option value="admin" <?= (($_GET['role'] ?? '') == 'admin') ? 'selected' : '' ?>>Administrator</option>
                    <option value="anggota" <?= (($_GET['role'] ?? '') == 'anggota') ? 'selected' : '' ?>>Anggota</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-light border px-4 fw-bold" style="border-radius: 10px;">
                    Cari
                </button>
                <a href="<?= base_url('users') ?>" class="btn btn-light border px-3" style="border-radius: 10px;">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="card user-card-table shadow-sm">
        <div class="table-responsive">
            <table class="table berry-table mb-0">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Akun & Kontak</th>
                        <th>Akses</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if ($u['foto']): ?>
                                            <img src="<?= base_url('uploads/users/' . $u['foto']) ?>" class="img-user-list">
                                        <?php else: ?>
                                            <div class="img-user-list bg-light-purple d-flex align-items-center justify-content-center fw-bold text-primary">
                                                <?= strtoupper(substr($u['nama'], 0, 1)) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-bold mb-0"><?= $u['nama'] ?></div>
                                            <span class="text-muted extra-small">ID: #<?= str_pad($u['id'], 4, '0', STR_PAD_LEFT) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold small">@<?= $u['username'] ?></div>
                                    <div class="text-muted extra-small"><?= $u['email'] ?></div>
                                </td>
                                <td>
                                    <?php 
                                        $class = ($u['role'] == 'admin') ? 'bg-light-danger' : (($u['role'] == 'petugas') ? 'bg-light-warning' : 'bg-light-blue');
                                        $text = ($u['role'] == 'admin') ? '#d84315' : (($u['role'] == 'petugas') ? '#ffc107' : '#2196f3');
                                    ?>
                                    <span class="badge-berry <?= $class ?>" style="color: <?= $text ?>;">
                                        <?= strtoupper($u['role']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="<?= base_url('users/edit/' . $u['id']) ?>" class="btn btn-sm btn-light border-0" style="border-radius: 8px;">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>
                                    <a href="<?= base_url('users/delete/' . $u['id']) ?>" class="btn btn-sm btn-light border-0" onclick="return confirm('Hapus user?')" style="border-radius: 8px;">
                                        <i class="bi bi-trash3 text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <h6 class="text-muted">Data tidak ditemukan...</h6>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        <?= $pager->links() ?>
    </div>
</div>

<?= $this->endSection() ?>