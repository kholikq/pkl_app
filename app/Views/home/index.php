<div class="text-center mb-5">
    <h1 class="my-4 display-4">Selamat Datang di Sistem Informasi PKL</h1>
    <p class="lead">Sistem ini dirancang untuk mempermudah pengelolaan Praktik Kerja Lapangan.</p>
</div>

<!-- Filter Tahun Ajaran -->
<section id="tahun-filter" class="mb-4">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="input-group">
                <label class="input-group-text rounded-pill-start bg-primary text-white" for="selectYear">Tahun Ajaran</label>
                <select class="form-select rounded-pill-end" id="selectYear" onchange="filterByYear(this.value)">
                    <?php
                        $currentYear = date('Y');
                        $startYear = 2023; // Tahun awal data Anda
                        for ($year = $currentYear + 1; $year >= $startYear; $year--):
                    ?>
                        <option value="<?= $year ?>" <?= ($year == $selectedYear) ? 'selected' : '' ?>>
                            <?= $year ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Rekap Siswa -->
<section id="statistik-rekap" class="mb-5">
    <h2 class="text-center mb-4">Statistik PKL Tahun <?= $selectedYear; ?></h2>
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Siswa</h5>
                    <p class="card-text display-4 text-primary"><?= $totalSiswa; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Siswa Mengajukan</h5>
                    <p class="card-text display-4 text-info"><?= $siswaMengajukan; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Ajuan Disetujui</h5>
                    <p class="card-text display-4 text-success"><?= $statsAjuan->disetujui_semua; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Ajuan Menunggu</h5>
                    <p class="card-text display-4 text-warning"><?= $statsAjuan->menunggu_verifikasi; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Alur Pengajuan PKL -->
<section id="alur-pkl" class="mb-5">
    <h2 class="text-center mb-4">Alur Pengajuan PKL</h2>
    <?php if (!empty($alurPkl)): ?>
        <div class="row justify-content-center">
            <?php $i = 1; foreach ($alurPkl as $alur): ?>
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-lg h-100">
                        <div class="card-body text-center">
                            <div class="icon-circle mb-3 bg-primary text-white mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%;">
                                <h3 class="m-0"><?= $i++; ?></h3>
                            </div>
                            <h5 class="card-title"><?= esc($alur->judul_alur); ?></h5>
                            <p class="card-text text-muted"><?= esc($alur->deskripsi_alur); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="alert alert-info text-center">Belum ada alur pengajuan PKL yang ditambahkan. Silakan tambahkan melalui admin.</p>
    <?php endif; ?>
</section>

<div class="text-center mt-5">
    <!-- Mengubah tombol "Ajukan PKL Sekarang" menjadi "Daftar Akun Baru" -->
    <a href="<?= base_url('auth/register'); ?>" class="btn btn-success btn-lg">Daftar Akun Baru</a>
    <a href="<?= base_url('auth/login'); ?>" class="btn btn-outline-primary btn-lg ms-2">Login</a>
</div>

<!-- JavaScript untuk filter tahun -->
<script>
    function filterByYear(year) {
        window.location.href = '<?= base_url('home'); ?>?tahun=' + year;
    }
</script>

<!-- Tambahkan CSS kustom untuk icon-circle dan rounded-pill-end/start -->
<style>
    .icon-circle {
        font-size: 1.8rem;
        font-weight: bold;
    }
    /* Custom styles for rounded-pill-start and rounded-pill-end */
    .rounded-pill-start {
        border-top-left-radius: 50rem !important;
        border-bottom-left-radius: 50rem !important;
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
    .rounded-pill-end {
        border-top-right-radius: 50rem !important;
        border-bottom-right-radius: 50rem !important;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }
</style>
