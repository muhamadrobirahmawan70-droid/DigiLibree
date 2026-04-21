<div class="p-4 text-center border-bottom bg-light">
    <a href="#" class="text-decoration-none">
        <h4 class="fw-bold text-primary mb-0">DigiLibree<span class="text-dark">App</span></h4>
    </a>
</div>

<div class="p-4">
    <div class="text-center mb-4 pb-3 border-bottom">
        <div class="position-relative d-inline-block mb-3">
            <img src="<?= base_url('uploads/users/' . session()->get('foto')) ?>" 
                 class="rounded-circle border border-3 border-white shadow-sm"
                 style="object-fit: cover; width: 85px; height: 85px;">
            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2"></span>
        </div>
        <h6 class="fw-bold mb-0"><?= session('nama'); ?></h6>
        <small class="badge rounded-pill bg-soft-primary text-primary px-3 shadow-sm" style="background-color: #e7f1ff;">
            <?= ucfirst(session('role')); ?>
        </small>
    </div>

    <div class="nav-container">
        <label class="text-muted small fw-bold text-uppercase mb-3 d-block opacity-50" style="letter-spacing: 1px;">Main Menu</label>
        
        <a href="<?= base_url('/') ?>" class="nav-link-custom <?= current_url() == base_url('/') ? 'active' : '' ?>">
            <i class="bi bi-speedometer2 me-3"></i> Dashboard
        </a>

        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
            <a href="<?= base_url('/users') ?>" class="nav-link-custom">
                <i class="bi bi-people me-3"></i> Manajemen Users
            </a>
        <?php endif; ?>

        <a href="<?= base_url('/buku') ?>" class="nav-link-custom">
            <i class="bi bi-book me-3"></i> Katalog Buku
        </a>
       
        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas' || session()->get('role')) : ?>
            <a href="<?= base_url('/peminjaman') ?>" class="nav-link-custom">
                <i class="bi bi-arrow-left-right me-3"></i> Transaksi Pinjam
            </a>
        <?php endif; ?>

         <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
            <a href="<?= base_url('/log') ?>" class="nav-link-custom">
                <i class="bi bi-clock-history me-3"></i> Log Aktivitas
            </a>
        <?php endif; ?>
        <a href="<?= base_url('peminjaman/riwayat') ?>" class="nav-link-custom <?= current_url() == base_url('peminjaman/riwayat') ? 'active' : '' ?>">
            <i class="bi bi-clock-history me-3"></i> Riwayat Membaca
        </a>
        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
        <li class="nav-item mb-2">
    <a href="<?= base_url('denda') ?>" class="nav-link rounded-3 py-2 px-3 d-flex align-items-center transition-all <?= (uri_string() == 'denda') ? 'bg-primary text-white shadow-sm' : 'text-muted' ?>">
        <div class="icon-box me-3 d-flex align-items-center justify-content-center <?= (uri_string() == 'denda') ? 'text-white' : 'text-primary bg-light' ?>" style="width: 35px; height: 35px; border-radius: 10px;">
            <i class="bi bi-cash-stack fs-5"></i>
        </div>
        <span class="fw-semibold">Data Denda</span>
        <?php 
            // Opsional: Notifikasi angka denda aktif (Badge)
            $db = \Config\Database::connect();
            $countDenda = $db->table('peminjaman')->where('denda >', 0)->countAllResults();
            if ($countDenda > 0) : 
        ?>
            <span class="badge rounded-pill bg-danger ms-auto shadow-sm"><?= $countDenda ?></span>
        <?php endif; ?>
    </a>
</li>
 <?php endif; ?>
        <label class="text-muted small fw-bold text-uppercase mt-4 mb-3 d-block opacity-50" style="letter-spacing: 1px;">Account</label>

        <?php $idu = session('id'); ?>
        <a href="<?= base_url('users/edit/' . $idu) ?>" class="nav-link-custom">
            <i class="bi bi-gear me-3"></i> Account Setting
        </a>

        <a href="<?= site_url('/logout') ?>" class="nav-link-custom text-danger mt-2">
            <i class="bi bi-box-arrow-right me-3"></i> Log Out
        </a>
    </div>
</div>


<style>
    .nav-link-custom {
        display: flex;
        align-items: center;
        padding: 12px 18px;
        margin-bottom: 8px;
        border-radius: 12px;
        color: #555;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .nav-link-custom:hover {
        background-color: #f0f4f8;
        color: #0d6efd;
        transform: translateX(5px);
    }

    .nav-link-custom.active {
        background-color: #0d6efd;
        color: white;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    .nav-link-custom i {
        font-size: 1.2rem;
    }

    .bg-soft-primary {
        font-weight: 600;
        font-size: 0.75rem;
    }
    <style>
    .nav-link {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    .nav-link:hover {
        background-color: rgba(13, 110, 253, 0.05);
        color: #0d6efd !important;
        transform: translateX(5px);
    }
    .nav-link.bg-primary:hover {
        background-color: #0b5ed7 !important;
        color: white !important;
        transform: none; /* Biar yang aktif nggak geser */
    }
    .icon-box {
        transition: all 0.3s ease;
    }
</style>
</style>