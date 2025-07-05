<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi PKL</title>
    <!-- Link Bootstrap CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS untuk menyesuaikan tampilan -->
    <style>
        body { padding-top: 56px; font-family: 'Inter', sans-serif; } /* Menyesuaikan untuk fixed navbar */
        .rounded-pill { border-radius: 50rem !important; } /* Menambahkan rounded-pill untuk input/select */
        .card { border-radius: 15px; overflow: hidden; }
        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            background: linear-gradient(45deg, #007bff, #0056b3);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
            cursor: pointer;
        }
        .table thead th {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <!-- Navbar Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow-sm">
        <div class="container-fluid">
            <!-- Brand aplikasi -->
            <a class="navbar-brand fw-bold" href="<?= base_url(); ?>">PKL App</a>
            <!-- Tombol toggler untuk mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menu navigasi -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (uri_string() == '' || uri_string() == 'home') ? 'active' : '' ?>" aria-current="page" href="<?= base_url('home'); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <!-- Mengubah link "Ajuan Baru" menjadi "Pendaftaran Akun" -->
                        <a class="nav-link <?= (uri_string() == 'auth/register') ? 'active' : '' ?>" href="<?= base_url('auth/register'); ?>">Pendaftaran Akun</a>
                    </li>
                    <li class="nav-item">
                        <!-- Mengubah link "Ajuan Baru" menjadi "Pendaftaran Akun" -->
                        <a class="nav-link <?= (uri_string() == 'ajuan_baru') ? 'active' : '' ?>" href="<?= base_url('ajuan_baru'); ?>">Ajuan Baru</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= (uri_string() == 'data/siswa' || uri_string() == 'data/dudi') ? 'active' : '' ?>" href="#" id="navbarDropdownData" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Data Master
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownData">
                            <li><a class="dropdown-item <?= (uri_string() == 'data/siswa') ? 'active' : '' ?>" href="<?= base_url('data/siswa'); ?>">Data Siswa</a></li>
                            <li><a class="dropdown-item <?= (uri_string() == 'data/dudi') ? 'active' : '' ?>" href="<?= base_url('data/dudi'); ?>">Data DU/DI</a></li>
                            <!-- Tambahkan link lain sesuai kebutuhan -->
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (uri_string() == 'unduh_file') ? 'active' : '' ?>" href="<?= base_url('unduh_file'); ?>">Unduh File</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (uri_string() == 'sertifikat') ? 'active' : '' ?>" href="<?= base_url('sertifikat'); ?>">Sertifikat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (uri_string() == 'auth/login') ? 'active' : '' ?>" href="<?= base_url('auth/login'); ?>">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Konten utama akan dimuat di sini -->
