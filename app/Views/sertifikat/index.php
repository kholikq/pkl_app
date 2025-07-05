<!-- Container utama untuk halaman -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <!-- Header card -->
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="fw-light my-0">Daftar Sertifikat PKL</h3>
                </div>
                <!-- Body card berisi tabel data -->
                <div class="card-body p-4">
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

                    <!-- Filter Tahun Terbit & Pencarian -->
                    <div class="row mb-4 align-items-end">
                        <div class="col-md-5 mb-3 mb-md-0">
                            <label for="selectYearSertifikat" class="form-label visually-hidden">Tahun Terbit</label>
                            <div class="input-group">
                                <label class="input-group-text rounded-pill-start bg-primary text-white" for="selectYearSertifikat">Tahun</label>
                                <select class="form-select rounded-pill-end" id="selectYearSertifikat" onchange="applySertifikatSearch()">
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
                            <label for="searchInputSertifikat" class="form-label visually-hidden">Cari Sertifikat</label>
                            <div class="input-group">
                                <input type="text" class="form-control rounded-pill-start" id="searchInputSertifikat" placeholder="Cari NISN atau Nama Siswa..." value="<?= esc($searchQuery); ?>">
                                <button class="btn btn-primary rounded-pill-end" type="button" onclick="applySertifikatSearch()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($sertifikatList)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>DU/DI</th>
                                        <th>Nomor Sertifikat</th>
                                        <th>Tanggal Terbit</th>
                                        <!-- Kolom Aksi dihilangkan dari tampilan publik -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Hitung nomor urut berdasarkan halaman dan perPage
                                        $currentPage = $pager->getCurrentPage();
                                        $perPageCount = $pager->getPerPage();
                                        $no = ($currentPage - 1) * $perPageCount + 1;
                                    ?>
                                    <?php foreach ($sertifikatList as $sertifikat): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= esc($sertifikat->nisn); ?></td>
                                            <td><?= esc($sertifikat->nama_siswa); ?></td>
                                            <td><?= esc($sertifikat->kelas); ?></td>
                                            <td><?= esc($sertifikat->jurusan); ?></td>
                                            <td><?= esc($sertifikat->nama_dudi ?? 'N/A'); ?></td>
                                            <td><?= esc($sertifikat->nomor_sertifikat ?? '-'); ?></td>
                                            <td><?= esc($sertifikat->tanggal_terbit ?? '-'); ?></td>
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
                            Belum ada sertifikat yang diterbitkan untuk tahun ajaran <?= $selectedYear; ?>
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

<!-- JavaScript untuk pencarian -->
<script>
    const searchInputSertifikat = document.getElementById('searchInputSertifikat');
    const selectYearSertifikat = document.getElementById('selectYearSertifikat'); // Ambil elemen dropdown tahun
    let searchTimeoutSertifikat = null; // Untuk debouncing

    // Fungsi untuk menerapkan pencarian (memuat ulang halaman dengan parameter query)
    function applySertifikatSearch() {
        const searchQuery = searchInputSertifikat.value;
        const selectedYear = selectYearSertifikat.value; // Ambil nilai tahun terpilih
        let url = '<?= base_url('sertifikat'); ?>';
        
        let params = [];
        if (searchQuery) {
            params.push('q=' + encodeURIComponent(searchQuery));
        }
        if (selectedYear) {
            params.push('tahun=' + encodeURIComponent(selectedYear));
        }

        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        
        window.location.href = url; // Memuat ulang halaman
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Event listener untuk input pencarian
        searchInputSertifikat.addEventListener('keyup', function() {
            const term = this.value;

            clearTimeout(searchTimeoutSertifikat); // Hapus timeout sebelumnya
            if (term.length > 0) { // Terapkan pencarian jika ada input
                searchTimeoutSertifikat = setTimeout(() => {
                    applySertifikatSearch(); // Panggil fungsi pencarian yang memuat ulang halaman
                }, 800); // Debounce time 800ms
            } else {
                // Jika input kosong, dan sebelumnya ada query, muat ulang halaman untuk menghapus filter
                if ('<?= esc($searchQuery); ?>' !== '') {
                    applySertifikatSearch();
                }
            }
        });

        // Tambahkan event listener untuk saat input kehilangan fokus (blur)
        searchInputSertifikat.addEventListener('blur', function() {
            clearTimeout(searchTimeoutSertifikat); // Pastikan tidak ada timeout yang tertunda
            if (this.value !== '<?= esc($searchQuery); ?>') { // Hanya picu jika nilai berubah
                applySertifikatSearch();
            }
        });

        // Opsional: Jika user menekan Enter di kolom pencarian, langsung picu pencarian
        searchInputSertifikat.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Mencegah form submit default
                clearTimeout(searchTimeoutSertifikat);
                applySertifikatSearch();
            }
        });

        // Event listener untuk perubahan dropdown tahun
        selectYearSertifikat.addEventListener('change', function() {
            applySertifikatSearch(); // Panggil fungsi pencarian saat tahun berubah
        });
    });
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
