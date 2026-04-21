<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark"><i class="bi bi-people-fill me-2 text-primary"></i>Manajemen Users</h2>
            <p class="text-muted">Kelola data anggota, petugas, dan admin DigiLibree di sini.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <form method="get" action="" class="d-flex gap-2 justify-content-md-end">
                <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border" style="max-width: 250px;">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" class="form-control border-0 shadow-none" placeholder="Cari nama..." value="<?= $_GET['keyword'] ?? '' ?>">
                </div>

                <select name="role" class="form-select border-0 shadow-sm rounded-pill" style="max-width: 150px;">
                    <option value="">Semua Role</option>
                    <option value="admin" <?= (($_GET['role'] ?? '') == 'admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="petugas" <?= (($_GET['role'] ?? '') == 'petugas') ? 'selected' : '' ?>>Petugas</option>
                    <option value="anggota" <?= (($_GET['role'] ?? '') == 'anggota') ? 'selected' : '' ?>>Anggota</option>
                </select>

                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Filter</button>
                <a href="<?= base_url('users') ?>" class="btn btn-light rounded-circle shadow-sm text-muted" title="Reset">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </form>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 animate__animated animate__fadeIn">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">User</th>
                        <th>Username & Email</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if ($u['foto']): ?>
                                            <img src="<?= base_url('uploads/users/' . $u['foto']) ?>" class="rounded-circle border" width="45" height="45" style="object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-soft-primary text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; background: #e7f1ff;">
                                                <?= substr($u['nama'], 0, 1) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-bold text-dark"><?= $u['nama'] ?></div>
                                            <small class="text-muted small">ID: #<?= $u['id'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-dark mb-0"><?= $u['username'] ?></div>
                                    <div class="text-muted small"><?= $u['email'] ?></div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 
                                        <?= ($u['role'] == 'admin') ? 'bg-soft-danger text-danger' : (($u['role'] == 'petugas') ? 'bg-soft-warning text-warning' : 'bg-soft-info text-info') ?>"
                                        style="background: <?= ($u['role'] == 'admin') ? '#ffeef3' : (($u['role'] == 'petugas') ? '#fff9db' : '#e7f8ff') ?>;">
                                        <?= ucfirst($u['role']) ?>
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <?php if (session()->get('role') == 'admin') : ?>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?= base_url('users/edit/' . $u['id']) ?>" class="btn btn-soft-primary btn-sm rounded-pill px-3">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </a>
                                            <a href="<?= base_url('users/delete/' . $u['id']) ?>" 
                                               class="btn btn-soft-danger btn-sm rounded-pill px-3" 
                                               onclick="return confirm('Hapus user ini?')">
                                                <i class="bi bi-trash-fill me-1"></i> Hapus
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">No Access</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-emoji-frown display-4 d-block mb-3"></i>
                                Yah, data user-nya gak ketemu...
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
    <div class="pagination-wrapper">
        <?= $pager->links() ?>
    </div>
</div>
<style>
    /* Tambahan CSS dikit biar tampilan pagination bawaan CI4 gak berantakan */
    .pagination-wrapper ul {
        display: flex;
        list-style: none;
        padding: 0;
        gap: 5px;
    }
    .pagination-wrapper li a {
        padding: 8px 16px;
        border: 1px solid #dee2e6;
        border-radius: 50px;
        text-decoration: none;
        color: #0d6efd;
        transition: all 0.3s;
    }
    .pagination-wrapper li.active a {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    .pagination-wrapper li a:hover:not(.active) {
        background-color: #f8f9fa;
    }
</style>

<?= $this->endSection() ?>