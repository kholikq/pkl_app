<!-- Container utama untuk halaman -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <!-- Header card -->
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="fw-light my-0">Data Dunia Usaha / Dunia Industri (DU/DI)</h3>
                </div>
                <!-- Body card berisi tabel data -->
                <div class="card-body p-4">
                    <!-- Pencarian -->
                    <div class="row mb-4 justify-content-end">
                        <div class="col-md-6">
                            <label for="searchInputDudi" class="form-label visually-hidden">Cari DU/DI</label>
                            <div class="input-group">
                                <!-- Input pencarian dengan datalist untuk rekomendasi -->
                                <input type="text" class="form-control rounded-pill-start" id="searchInputDudi" placeholder="Cari Nama DU/DI..." value="<?= esc($searchQuery); ?>" list="dudiSuggestions">
                                <!-- Tombol Cari, sekarang hanya sebagai visual atau fallback -->
                                <button class="btn btn-primary rounded-pill-end" type="button" onclick="applyDudiSearch()">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                            <!-- Datalist untuk rekomendasi pencarian (autocomplete) -->
                            <datalist id="dudiSuggestions"></datalist>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama DU/DI</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <!-- <th>Email</th> -->
                                    <th>Referensi Jurusan</th>
                                </tr>
                            </thead>
                            <tbody id="dudiTableBody">
                                <?php
                                // Render data langsung dari PHP
                                if (!empty($dudiList)) {
                                    $currentPage = $pager->getCurrentPage();
                                    $perPage = $pager->getPerPage();
                                    $no = ($currentPage - 1) * $perPage + 1;
                                    foreach ($dudiList as $dudi) {
                                        echo '<tr>';
                                        echo '<td>' . $no++ . '</td>';
                                        echo '<td>' . esc($dudi->nama_dudi) . '</td>';
                                        echo '<td>' . esc($dudi->alamat_dudi ?? '-') . '</td>';
                                        echo '<td>' . esc($dudi->telepon_dudi ?? '-') . '</td>';
                                        // echo '<td>' . esc($dudi->email_dudi ?? '-') . '</td>';
                                        echo '<td>' . esc($dudi->referensi_jurusan ?? '-') . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center">Tidak ada data DU/DI.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginasi -->
                    <div id="paginationLinks" class="d-flex justify-content-center mt-3">
                        <?php if ($pager): ?>
                            <?= $pager->links('default', 'bootstrap_full'); ?>
                        <?php endif; ?>
                    </div>

                    <?php // Alert no data, awalnya disembunyikan jika ada data, atau ditampilkan jika tidak ada ?>
                    <div id="noDataAlert" class="alert alert-info text-center" role="alert" style="display: <?= empty($dudiList) ? 'block' : 'none'; ?>;">
                        Tidak ada data DU/DI
                        <?= !empty($searchQuery) ? " dengan pencarian '<b>" . esc($searchQuery) . "</b>'." : "." ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome untuk ikon pencarian -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- JavaScript untuk pencarian otomatis dan rekomendasi -->
<script>
    const searchInput = document.getElementById('searchInputDudi');
    const dudiSuggestions = document.getElementById('dudiSuggestions');
    // const dudiTableBody = document.getElementById('dudiTableBody'); // Tidak lagi diperlukan untuk update AJAX tabel
    // const paginationLinks = document.getElementById('paginationLinks'); // Tidak lagi diperlukan untuk update AJAX paginasi
    const noDataAlert = document.getElementById('noDataAlert');

    let autocompleteTimeout = null; // Untuk debouncing autocomplete
    let searchTimeout = null; // Untuk debouncing pencarian otomatis

    // Fungsi untuk menerapkan pencarian (memuat ulang halaman dengan parameter query)
    function applyDudiSearch() {
        const searchQuery = searchInput.value;
        let url = '<?= base_url('data/dudi'); ?>';
        if (searchQuery) {
            url += '?q=' + encodeURIComponent(searchQuery);
        }
        window.location.href = url; // Memuat ulang halaman
    }

    document.addEventListener('DOMContentLoaded', function() {
        searchInput.addEventListener('keyup', function() {
            const term = this.value;

            // --- Logika untuk Autocomplete (Rekomendasi) ---
            clearTimeout(autocompleteTimeout);
            if (term.length < 3) {
                dudiSuggestions.innerHTML = ''; // Kosongkan rekomendasi jika kurang dari 3 karakter
            } else {
                autocompleteTimeout = setTimeout(() => {
                    fetch('<?= base_url('data/getDudiSuggestions'); ?>?term=' + encodeURIComponent(term))
                        .then(response => response.json())
                        .then(data => {
                            dudiSuggestions.innerHTML = ''; // Bersihkan rekomendasi sebelumnya
                            data.forEach(suggestion => {
                                const option = document.createElement('option');
                                option.value = suggestion;
                                dudiSuggestions.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching DU/DI suggestions:', error));
                }, 300); // Debounce time 300ms untuk autocomplete
            }

            // --- Logika untuk Pencarian Otomatis (memuat ulang halaman) ---
            clearTimeout(searchTimeout); // Hapus timeout pencarian otomatis sebelumnya
            if (term.length > 0) { // Terapkan pencarian jika ada input (bahkan jika kurang dari 3 untuk menghapus filter)
                searchTimeout = setTimeout(() => {
                    applyDudiSearch(); // Panggil fungsi pencarian yang memuat ulang halaman
                }, 800); // Debounce time 800ms untuk pencarian otomatis (lebih lama dari autocomplete)
            } else {
                // Jika input kosong, dan sebelumnya ada query, muat ulang halaman untuk menghapus filter
                if ('<?= esc($searchQuery); ?>' !== '') {
                    applyDudiSearch();
                }
            }
        });

        // Tambahkan event listener untuk saat input kehilangan fokus (blur)
        // Ini memastikan pencarian terpicu bahkan jika user tidak menekan Enter
        searchInput.addEventListener('blur', function() {
            clearTimeout(searchTimeout); // Pastikan tidak ada timeout yang tertunda
            if (this.value !== '<?= esc($searchQuery); ?>') { // Hanya picu jika nilai berubah
                applyDudiSearch();
            }
        });

        // Opsional: Jika user menekan Enter di kolom pencarian, langsung picu pencarian
        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Mencegah form submit default
                clearTimeout(searchTimeout); // Hapus timeout jika user menekan Enter
                applyDudiSearch();
            }
        });

        // Event delegation untuk link paginasi (untuk link yang dirender PHP)
        // Tidak perlu AJAX di sini karena paginasi akan memicu page reload
        // Link paginasi akan bekerja secara default dengan URL query string
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
