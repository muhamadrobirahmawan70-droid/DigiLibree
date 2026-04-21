<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DigiLibree - Digital Library App</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', 'SF Pro', "Segoe UI", sans-serif;
            display: flex;
            min-height: 100vh;
            background-color: #f0f2f5;
            margin: 0;
        }

        /* Sidebar Modern DigiLibree */
        .sidebar {
            width: 260px; /* Diperlebar sedikit agar menu tidak sesak */
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            z-index: 1000;
        }

        /* Styling untuk link di dalam menu.php */
        .sidebar a {
            color: rgba(255, 255, 255, 0.8) !important;
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            border-radius: 10px;
            margin: 4px 15px;
            transition: all 0.2s;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateX(5px);
        }

        .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
            font-weight: bold;
        }

        .content {
            flex-grow: 1;
            padding: 30px;
            background-color: #f0f2f5;
            overflow-y: auto;
        }

        /* Header di dalam konten */
        .content-header {
            margin-bottom: 25px;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        /* Scrollbar biar cantik */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #764ba2;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div id="sidebar" class="sidebar">
        <div class="p-4 text-center">
            <h4 class="fw-bold mb-0 text-white"><i class="bi bi-collection-play-fill me-2"></i>DigiLibree</h4>
            <hr class="border-light opacity-50">
        </div>
        
        <?php include(APPPATH . 'Views/layouts/menu.php'); ?>
    </div>

    <div class="content">
        <div class="container-fluid">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>