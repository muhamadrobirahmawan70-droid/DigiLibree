<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-5" style="background-color: #f8fafc; min-height: 100vh;">
    
    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <h2 class="fw-800 text-dark mb-1" style="letter-spacing: -1px;">
                <i class="bi bi-people-fill text-primary me-2"></i>Database Pengguna
            </h2>
            <p class="text-muted mb-0 small">Kelola kendali akses anggota, dan administrator.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <a href="<?= base_url('users/create') ?>" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah User Baru
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <form method="get" action="" class="row g-3 align-items-center">
                    <div class="col-md-5 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-pill px-3">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="keyword" class="form-control bg-light border-0 rounded-end-pill py-2" 
                                   placeholder="Cari nama atau username..." value="<?= $_GET['keyword'] ?? '' ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-3">
                        <select name="role" class="form-select bg-light border-0 rounded-pill py-2 fw-semibold text-muted">
                            <option value="">Semua Hak Akses</option>
                            <option value="admin" <?= (($_GET['role'] ?? '') == 'admin') ? 'selected' : '' ?>>Administrator</option>
                            <option value="anggota" <?= (($_GET['role'] ?? '') == 'anggota') ? 'selected' : '' ?>>Anggota</option>
                        </select>
                    </div>

                    <div class="col-md-3 col-lg-5 d-flex gap-2">
                        <button type="submit" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm">
                            <i class="bi bi-filter me-2"></i>Terapkan Filter
                        </button>
                        <a href="<?= base_url('users') ?>" class="btn btn-light rounded-pill border px-3 py-2 text-muted shadow-sm" title="Reset">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center animate__animated animate__fadeIn">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div>
                <strong class="d-block">Berhasil!</strong>
                <span class="small"><?= session()->getFlashdata('success') ?></span>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-5 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-primary text-white small text-uppercase ls-1">
                    <tr>
                        <th class="ps-4 py-3 fw-800">Identitas User</th>
                        <th class="py-3 fw-800">Akun & Kontak</th>
                        <th class="py-3 fw-800">Role</th>
                        <th class="text-center py-3 fw-800">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td class="ps-4 py-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if ($u['foto']): ?>
                                            <img src="<?= base_url('uploads/users/' . $u['foto']) ?>" class="rounded-circle border border-2 border-white shadow-sm" width="48" height="48" style="object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-primary-soft text-primary d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 48px; height: 48px;">
                                                <?= strtoupper(substr($u['nama'], 0, 1)) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-bold text-dark mb-0"><?= $u['nama'] ?></div>
                                            <span class="text-muted extra-small">ID: #<?= str_pad($u['id'], 4, '0', STR_PAD_LEFT) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark small mb-0">@<?= $u['username'] ?></div>
                                    <div class="text-muted extra-small"><?= $u['email'] ?></div>
                                </td>
                                <td>
                                    <?php 
                                        $color = ($u['role'] == 'admin') ? 'danger' : (($u['role'] == 'petugas') ? 'warning' : 'info');
                                    ?>
                                    <span class="badge rounded-pill px-3 py-2 fw-bold text-uppercase bg-<?= $color ?>-subtle text-<?= $color ?>" style="font-size: 0.65rem;">
                                        <?= $u['role'] ?>
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2">
                                            <li><a class="dropdown-item rounded-3 py-2" href="<?= base_url('users/edit/' . $u['id']) ?>"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Data</a></li>
                                            <li><hr class="dropdown-divider text-light"></li>
                                            <li><a class="dropdown-item rounded-3 py-2 text-danger" href="<?= base_url('users/delete/' . $u['id']) ?>" onclick="return confirm('Hapus user?')"><i class="bi bi-trash3 me-2"></i>Hapus User</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-search text-light-gray display-1"></i>
                                <h5 class="text-muted mt-3">Data tidak ditemukan...</h5>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5 d-flex justify-content-center">
        <div class="pagination-container p-2 bg-white rounded-pill shadow-sm border">
            <?= $pager->links() ?>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .fw-800 { font-weight: 800; }
    .ls-1 { letter-spacing: 1px; }
    .extra-small { font-size: 0.75rem; }
    .bg-primary-soft { background-color: #eff6ff; }
    
    /* Warna Badge Modern */
    .bg-danger-subtle { background-color: #fff1f2 !important; }
    .text-danger { color: #e11d48 !important; }
    .bg-warning-subtle { background-color: #fefce8 !important; }
    .text-warning { color: #ca8a04 !important; }
    .bg-info-subtle { background-color: #ecfeff !important; }
    .text-info { color: #0891b2 !important; }

    /* Dropdown Hover */
    .dropdown-item:hover { background-color: #f8fafc; }

    /* Pagination */
    .pagination-container ul { display: flex; list-style: none; padding: 0; margin: 0; gap: 4px; }
    .pagination-container li a { padding: 6px 14px; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 0.85rem; color: #64748b; }
    .pagination-container li.active a { background-color: #3b82f6; color: white; }
</style>

<?= $this->endSection() ?>