<!-- Container utama untuk halaman -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <!-- Header card -->
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="fw-light my-0">Pendaftaran Akun Siswa PKL</h3>
                </div>
                <!-- Body card berisi form pendaftaran -->
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

                    <?php
                    // Ambil error validasi dari flashdata 'errors' yang dikirim controller
                    $validationErrors = session()->getFlashdata('errors');
                    ?>
                    <?php if ($validationErrors): ?>
                        <!-- Tampilkan pesan error umum di bagian atas form -->
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Informasi
                            <ul class="mb-0">
                                <?php foreach ($validationErrors as $field => $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?= form_open(base_url('auth/register')) ?>
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <!-- Tambahkan kelas is-invalid jika ada error untuk field nisn -->
                            <input type="text" class="form-control rounded-pill <?= isset($validationErrors['nisn']) ? 'is-invalid' : '' ?>" id="nisn" name="nisn" value="<?= old('nisn') ?>" placeholder="Masukkan NISN Anda" required autofocus>
                            <div class="form-text">NISN harus terdaftar di database sekolah.</div>
                            <?php if (isset($validationErrors['nisn'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc($validationErrors['nisn']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control rounded-pill <?= isset($validationErrors['password']) ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Buat Password Anda" required>
                            <div class="form-text">Password minimal 6 karakter.</div>
                            <?php if (isset($validationErrors['password'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc($validationErrors['password']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control rounded-pill <?= isset($validationErrors['confirm_password']) ? 'is-invalid' : '' ?>" id="confirm_password" name="confirm_password" placeholder="Ulangi Password Anda" required>
                            <?php if (isset($validationErrors['confirm_password'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc($validationErrors['confirm_password']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Daftar Akun</button>
                        </div>
                    <?= form_close() ?>

                    <div class="text-center mt-3">
                        Sudah punya akun? <a href="<?= base_url('auth/login'); ?>">Login di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS untuk tampilan yang menarik -->
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
    .form-control.rounded-pill, .btn.rounded-pill {
        padding: 0.75rem 1.5rem;
    }
    /* Gaya untuk input yang tidak valid */
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Debugging: Log nilai old('nisn') saat halaman dimuat
        console.log('old(\'nisn\') on page load:', '<?= old('nisn') ?>');

        // Debugging: Log semua error validasi yang diterima dari controller
        <?php
        $validationErrors = session()->getFlashdata('errors');
        if ($validationErrors): ?>
            console.log('Validation Errors received:', <?= json_encode($validationErrors) ?>);
        <?php else: ?>
            console.log('No validation errors received.');
        <?php endif; ?>
    });
</script>
