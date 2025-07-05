<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title); ?> | PKL App</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS untuk Admin Dashboard -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden; /* Mencegah scroll horizontal */
        }
        #wrapper {
            display: flex;
            transition: all 0.3s ease-in-out;
        }
        #sidebar-wrapper {
            min-width: 250px;
            max-width: 250px;
            background-color: #343a40; /* Dark sidebar */
            color: #fff;
            transition: all 0.3s ease-in-out;
            height: 100vh;
            position: sticky;
            top: 0;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1); /* Tambahkan shadow */
            z-index: 1000; /* Pastikan di atas konten lain */
        }
        #wrapper.toggled #sidebar-wrapper {
            margin-left: -250px; /* Sembunyikan sidebar */
        }
        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255,255,255,.1);
            margin-bottom: 20px;
        }
        #sidebar-wrapper .list-group {
            width: 100%;
        }
        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            color: #adb5bd;
            padding: 10px 20px;
            border: none;
            border-radius: 0;
            transition: all 0.3s;
        }
        #sidebar-wrapper .list-group-item:hover {
            background-color: #495057;
            color: #fff;
        }
        #sidebar-wrapper .list-group-item.active {
            background-color: #007bff; /* Primary color for active link */
            color: #fff;
        }
        #page-content-wrapper {
            width: 100%;
            padding: 20px;
            transition: all 0.3s ease-in-out;
        }
        #wrapper.toggled #page-content-wrapper {
            margin-left: 0; /* Sesuaikan margin konten saat sidebar tersembunyi */
        }
        .navbar-admin {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,.05);
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }
            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }
            #wrapper.toggled #sidebar-wrapper {
                margin-left: -250px;
            }
            #wrapper.toggled #page-content-wrapper {
                min-width: 100vw; /* Konten mengambil seluruh lebar viewport saat sidebar tersembunyi */
            }
        }
        @media (max-width: 767.98px) {
            #sidebar-wrapper {
                margin-left: -250px; /* Sembunyikan secara default di mobile */
                position: fixed; /* Agar sidebar bisa overlay */
            }
            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0; /* Tampilkan di mobile saat ditoggle */
            }
            #page-content-wrapper {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar - Terintegrasi langsung di sini -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">PKL Admin</div>
            <div class="list-group list-group-flush">
                <a href="<?= base_url('dashboard/admin'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'dashboard/admin') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="<?= base_url('dashboard/admin/ajuan'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'dashboard/admin/ajuan' || strpos(uri_string(), 'dashboard/admin/ajuan/') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-file-alt me-2"></i> Ajuan PKL
                </a>
                <a href="<?= base_url('dashboard/admin/siswa'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'dashboard/admin/siswa' || strpos(uri_string(), 'dashboard/admin/siswa/') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-user-graduate me-2"></i> Data Siswa
                </a>
                <a href="<?= base_url('dashboard/admin/dudi'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'dashboard/admin/dudi' || strpos(uri_string(), 'dashboard/admin/dudi/') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-building me-2"></i> Data DU/DI
                </a>
                <a href="<?= base_url('dashboard/admin/guru'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'dashboard/admin/guru' || strpos(uri_string(), 'dashboard/admin/guru/') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-chalkboard-teacher me-2"></i> Data Guru
                </a>
                <a href="<?= base_url('dashboard/admin/users'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'dashboard/admin/users' || strpos(uri_string(), 'dashboard/admin/users/') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-users-cog me-2"></i> Manajemen User
                </a>
                <a href="<?= base_url('dashboard/admin/alur'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'dashboard/admin/alur' || strpos(uri_string(), 'dashboard/admin/alur/') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-sitemap me-2"></i> Atur Alur PKL
                </a>
                <a href="<?= base_url('dashboard/admin/files'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'dashboard/admin/files' || strpos(uri_string(), 'dashboard/admin/files/') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-download me-2"></i> Kelola File Unduh
                </a>
                <a href="<?= base_url('dashboard/admin/sertifikat'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'dashboard/admin/sertifikat' || strpos(uri_string(), 'dashboard/admin/sertifikat/') === 0) ? 'active' : '' ?>">
                    <i class="fas fa-certificate me-2"></i> Kelola Sertifikat
                </a>
                <a href="<?= base_url('auth/logout'); ?>" class="list-group-item list-group-item-action">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light navbar-admin">
                <div class="container-fluid">
                    <!-- Tombol sidebarToggle diaktifkan kembali -->
                    <button class="btn btn-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                    <a class="navbar-brand ms-3" href="<?= base_url('dashboard/admin'); ?>">
                        Dashboard Admin
                    </a>
                    <div class="ms-auto">
                        <span class="navbar-text me-3">
                            Halo, <strong><?= esc($user['username']); ?></strong> (<?= esc($user['level']); ?>)
                        </span>
                        <a href="<?= base_url('auth/logout'); ?>" class="btn btn-outline-danger btn-sm">Logout</a>
                    </div>
                </div>
            </nav>
            <div class="container-fluid mt-4">
                <!-- Flashdata messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
