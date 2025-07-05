<!-- Container utama untuk halaman -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <!-- Header card -->
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="fw-light my-0">File Keperluan PKL</h3>
                </div>
                <!-- Body card berisi daftar file -->
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

                    <?php if (!empty($fileList)): ?>
                        <div class="list-group">
                            <?php foreach ($fileList as $file): ?>
                                <a href="<?= base_url('unduh_file/download/' . esc($file->lokasi_file)); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center mb-2 rounded shadow-sm">
                                    <div>
                                        <h5 class="mb-1 text-primary"><?= esc($file->nama_file); ?></h5>
                                        <small class="text-muted"><?= esc($file->deskripsi ?? 'Tidak ada deskripsi.'); ?></small>
                                    </div>
                                    <span class="badge bg-success rounded-pill p-2">Unduh <i class="fas fa-download ms-1"></i></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center" role="alert">
                            Belum ada file yang tersedia untuk diunduh.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome untuk ikon download -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
    .list-group-item {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .list-group-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    .badge {
        font-size: 0.9em;
    }
</style>
