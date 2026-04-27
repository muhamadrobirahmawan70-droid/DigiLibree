<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | DigiLibree</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --berry-purple: #673ab7;
            --berry-purple-light: #ede7f6;
            --berry-text: #364152;
            --berry-bg: #f4f7fb;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--berry-bg);
            margin: 0;
            display: flex;
        }

        /* Sidebar Ala Berry Vue */
        .sidebar {
            width: 270px;
            background: #ffffff;
            height: 100vh;
            position: fixed;
            border-right: 1px dashed #e3e8ef;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 32px 24px;
            display: flex;
            align-items: center;
        }

        .brand-logo-small {
            width: 35px;
            height: 35px;
            background: var(--berry-purple);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 12px;
        }

        .brand-name {
            font-weight: 700;
            font-size: 1.25rem;
            color: #121926;
            letter-spacing: -0.5px;
        }

        /* Styling Menu */
        .sidebar-menu-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #121926;
            padding: 20px 24px 10px;
            letter-spacing: 1px;
        }

        .sidebar a {
            color: var(--berry-text) !important;
            text-decoration: none;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            border-radius: 12px;
            margin: 4px 16px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar a i {
            font-size: 1.2rem;
            margin-right: 12px;
        }

        .sidebar a:hover {
            background-color: var(--berry-purple-light);
            color: var(--berry-purple) !important;
        }

        .sidebar a.active {
            background-color: var(--berry-purple-light);
            color: var(--berry-purple) !important;
            font-weight: 600;
        }

        /* Content Area */
        .main-wrapper {
            flex-grow: 1;
            margin-left: 270px;
            min-height: 100vh;
            padding: 20px;
        }

        .content-container {
            background: #ffffff;
            border-radius: 12px;
            min-height: calc(100vh - 40px);
            padding: 30px;
            border: 1px solid #e3e8ef;
        }

        /* Scrollbar Sidebar */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #e3e8ef;
            border-radius: 10px;
        }

        /* SweetAlert Custom untuk Berry */
        .swal2-popup {
            border-radius: 16px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
    </style>
</head>

<body>
    <div id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <div class="brand-logo-small">
                <i class="bi bi-collection-play-fill"></i>
            </div>
            <span class="brand-name">DigiLibree</span>
        </div>
        
        <div class="sidebar-content">
            
            
            <?php include(APPPATH . 'Views/layouts/menu.php'); ?>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="content-container shadow-sm">
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item small"><a href="#" class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item small active" aria-current="page">Halaman Sekarang</li>
                    </ol>
                </nav>
            </div>

            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    $(document).ready(function() {
        // Notifikasi Sukses
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success'); ?>',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        <?php endif; ?>

        // Notifikasi Gagal
        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Waduh!',
                text: '<?= session()->getFlashdata('error'); ?>',
                confirmButtonColor: '#673ab7',
                confirmButtonText: 'Oke, Saya Mengerti'
            });
        <?php endif; ?>
    });
    </script>
</body>
</html>