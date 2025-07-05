<!-- Container utama untuk halaman -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <!-- Header card -->
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="fw-light my-0">Data Siswa PKL (Terverifikasi)</h3>
                </div>
                <!-- Body card berisi tabel data -->
                <div class="card-body p-4">
                    <!-- Filter Tahun Ajaran & Pencarian -->
                    <div class="row mb-4 align-items-end">
                        <div class="col-md-5 mb-3 mb-md-0">
                            <label for="selectYearSiswa" class="form-label visually-hidden">Tahun Ajaran</label>
                            <div class="input-group">
                                <label class="input-group-text rounded-pill-start bg-primary text-white" for="selectYearSiswa">Tahun</label>
                                <select class="form-select rounded-pill-end" id="selectYearSiswa" onchange="applyFilters()">
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
                        <div class="col-md-7">
                            <label for="searchInputSiswa" class="form-label visually-hidden">Cari Siswa</label>
                            <div class="input-group">
                                <input type="text" class="form-control rounded-pill-start" id="searchInputSiswa" placeholder="Cari NISN atau Nama Siswa..." value="<?= esc($searchQuery); ?>">
                                <button class="btn btn-primary rounded-pill-end" type="button" onclick="applyFilters()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                        <!-- Bagian "Tampilkan" telah dihapus -->
                    </div>

                    <?php if (!empty($siswaData)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>DU/DI Tujuan</th>
                                        <th>Alamat DU/DI</th>
                                        <th>Guru Pembimbing</th>
                                        <!-- <th>Bidang Keahlian Guru</th> -->
                                        <th>Tgl Mulai PKL</th>
                                        <th>Tgl Selesai PKL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($siswaData as $siswa): ?>
                                        <tr>
                                            <td><?= esc($siswa->nisn); ?></td>
                                            <td><?= esc($siswa->nama_siswa); ?></td>
                                            <td><?= esc($siswa->kelas); ?></td>
                                            <td><?= esc($siswa->jurusan); ?></td>
                                            <td><?= esc($siswa->nama_dudi ?? 'Belum Ditentukan'); ?></td>
                                            <td><?= esc($siswa->alamat_dudi ?? 'N/A'); ?></td>
                                            <td><?= esc($siswa->nama_guru ?? 'Belum Ditentukan'); ?></td>
                                            <!-- <td><?= esc($siswa->bidang_keahlian ?? 'N/A'); ?></td> -->
                                            <td><?= esc($siswa->tanggal_mulai_pkl ?? 'Belum Ditentukan'); ?></td>
                                            <td><?= esc($siswa->tanggal_selesai_pkl ?? 'Belum Ditentukan'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginasi -->
                        <?php if ($pager): ?>
                            <div class="d-flex justify-content-center mt-3">
                                <?= $pager->links('default', 'bootstrap_full'); ?>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="alert alert-info text-center" role="alert">
                            Tidak ada data siswa PKL terverifikasi untuk tahun ajaran <?= $selectedYear; ?>
                            <?= !empty($searchQuery) ? " dengan pencarian '<b>" . esc($searchQuery) . "</b>'." : "." ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome untuk ikon pencarian -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- JavaScript untuk filter dan pencarian -->
<script>
    function applyFilters() {
        const selectedYear = document.getElementById('selectYearSiswa').value;
        const searchQuery = document.getElementById('searchInputSiswa').value;

        let url = '<?= base_url('data/siswa'); ?>?tahun=' + selectedYear;
        if (searchQuery) {
            url += '&q=' + encodeURIComponent(searchQuery);
        }
        // per_page tidak lagi ditambahkan ke URL karena dropdown "Tampilkan" dihapus
        window.location.href = url;
    }
</script>

<!-- Custom CSS untuk tampilan yang lebih menarik -->
<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
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
    .input-group .btn {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border-top-right-radius: 50rem !important;
        border-bottom-right-radius: 50rem !important;
    }
    .pagination .page-item .page-link {
        border-radius: 50rem;
        margin: 0 3px;
    }
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        border-radius: 50rem;
    }
</style>
