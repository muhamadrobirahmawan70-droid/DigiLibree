<div class="p-4">
    <div class="text-center mb-4 pb-3 border-bottom border-light">
        <div class="position-relative d-inline-block mb-3">
            <img src="<?= base_url('uploads/users/' . session()->get('foto')) ?>" 
                 class="rounded-circle border border-3 border-white shadow-sm"
                 style="object-fit: cover; width: 80px; height: 80px; background: #eee;">
            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-1" style="width: 15px; height: 15px;"></span>
        </div>
        <h6 class="fw-bold mb-1 text-dark"><?= session('nama'); ?></h6>
        <div class="d-flex justify-content-center">
            <span class="badge rounded-pill px-3 py-1" style="background-color: #ede7f6; color: #673ab7; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">
                <?= ucfirst(session('role')); ?>
            </span>
        </div>
    </div>

    <div class="nav-container">
        <label class="sidebar-menu-label">Menu Utama</label>
        
        <a href="<?= base_url('/') ?>" class="nav-link-custom <?= current_url() == base_url('/') ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
            <a href="<?= base_url('/users') ?>" class="nav-link-custom <?= strpos(current_url(), 'users') !== false ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i> Manajemen User
            </a>
        <?php endif; ?>

        <a href="<?= base_url('/buku') ?>" class="nav-link-custom <?= strpos(current_url(), 'buku') !== false ? 'active' : '' ?>">
            <i class="bi bi-journal-bookmark-fill"></i> Katalog Buku
        </a>
       
        <a href="<?= base_url('/peminjaman') ?>" class="nav-link-custom <?= strpos(current_url(), 'peminjaman') !== false && !strpos(current_url(), 'riwayat') ? 'active' : '' ?>">
            <i class="bi bi-arrow-left-right"></i> Transaksi Pinjam
        </a>

        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
            <a href="<?= base_url('denda') ?>" class="nav-link-custom <?= (uri_string() == 'denda') ? 'active' : '' ?>">
                <i class="bi bi-cash-stack"></i> Data Denda
                <?php 
                    $db = \Config\Database::connect();
                    $countDenda = $db->table('peminjaman')->where('denda >', 0)->countAllResults();
                    if ($countDenda > 0) : 
                ?>
                    <span class="badge rounded-pill bg-danger ms-auto" style="font-size: 0.65rem;"><?= $countDenda ?></span>
                <?php endif; ?>
            </a>

            <a href="<?= base_url('/log') ?>" class="nav-link-custom <?= (uri_string() == 'log') ? 'active' : '' ?>">
                <i class="bi bi-clock-history"></i> Log Aktivitas
            </a>
        <?php endif; ?>

        <?php if (session()->get('role') == 'anggota') : ?>
            <a href="<?= base_url('peminjaman/riwayat') ?>" class="nav-link-custom <?= current_url() == base_url('peminjaman/riwayat') ? 'active' : '' ?>">
                <i class="bi bi-calendar2-check"></i> Riwayat Membaca
            </a>
        <?php endif; ?>

        <label class="sidebar-menu-label mt-4">Pengaturan</label>

        <?php $idu = session('id'); ?>

<a href="<?= base_url('users/detail/' . $idu) ?>" class="nav-link-custom <?= strpos(current_url(), 'edit') !== false ? 'active' : '' ?> d-flex align-items-center justify-content-between">
    <span>
        <i class="bi bi-person-badge-fill me-2"></i> Profil & Kartu
    </span>
    <?php if(session('id')): ?>
        <span class="badge rounded-pill bg-purple-soft text-purple-berry extra-small border border-purple">
            ID: <?= str_pad(session('id'), 3, '0', STR_PAD_LEFT) ?>
        </span>
    <?php endif; ?>
</a>

        <?php if (session()->get('role') == 'admin') : ?>
            <a href="<?= base_url('/backup') ?>" class="nav-link-custom text-success">
                <i class="bi bi-database-fill-check"></i> Cadangkan Data
            </a>
        <?php endif; ?>

        <a href="<?= site_url('/logout') ?>" class="nav-link-custom text-danger mt-2">
            <i class="bi bi-box-arrow-right"></i> Keluar Sistem
        </a>
    </div>
</div>

<style>
    /* Reset gaya default dari file sebelumnya agar konsisten dengan Layout Utama */
    .nav-link-custom {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        margin-bottom: 4px;
        border-radius: 12px;
        color: #364152 !important; /* Warna teks gelap khas Berry */
        font-weight: 500;
        text-decoration: none;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .nav-link-custom i {
        font-size: 1.2rem;
        margin-right: 14px;
        opacity: 0.8;
    }

    /* Efek Hover */
    .nav-link-custom:hover {
        background-color: #ede7f6; /* Ungu muda */
        color: #673ab7 !important; /* Ungu Berry */
        transform: translateX(4px);
    }

    /* Menu Aktif */
    .nav-link-custom.active {
        background-color: #ede7f6 !important;
        color: #673ab7 !important;
        font-weight: 600;
    }
    
    .nav-link-custom.active i {
        color: #673ab7;
        opacity: 1;
    }

    .sidebar-menu-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #121926;
        padding: 15px 16px 8px;
        letter-spacing: 0.5px;
        display: block;
        opacity: 0.8;
    }
    /* Tambahan dikit biar badge di menu makin manis */
    .bg-purple-soft { background-color: rgba(103, 58, 183, 0.1); }
    .text-purple-berry { color: #673ab7; }
    .border-purple { border-color: rgba(103, 58, 183, 0.2) !important; }
    
    .nav-link-custom.active .badge {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        border-color: rgba(255, 255, 255, 0.3) !important;
    }
</style>