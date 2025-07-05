<!-- Container utama untuk halaman -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <!-- Header card -->
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="fw-light my-0">Login Sistem Informasi PKL</h3>
                </div>
                <!-- Body card berisi form login -->
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

                    <?php if (isset($errors)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form login -->
                    <?= form_open(base_url('auth/authenticate')) ?>
                        <!-- Input Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control rounded-pill" id="username" name="username" value="<?= old('username') ?>" placeholder="Masukkan username Anda" required autofocus>
                        </div>

                        <!-- Input Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control rounded-pill" id="password" name="password" placeholder="Masukkan password Anda" required>
                        </div>

                        <!-- Tombol Login -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Login</button>
                        </div>
                    <?= form_close() ?>

                    <div class="text-center mt-3">
                        <small class="text-muted">Lupa password? Silakan hubungi admin.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    .form-control.rounded-pill, .btn.rounded-pill {
        padding: 0.75rem 1.5rem;
    }
</style>
