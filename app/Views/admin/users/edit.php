<div class="row">
    <div class="col-12">
        <h1 class="mt-4 mb-4"><?= esc($title); ?></h1>
        <p class="lead">Edit detail pengguna di bawah ini.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                Formulir Edit Pengguna: <?= esc($userData->username); ?>
            </div>
            <div class="card-body">
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
                $validation = \Config\Services::validation();
                ?>
                <?php if ($validation->getErrors()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Terjadi kesalahan validasi:
                        <ul class="mb-0">
                            <?php foreach ($validation->getErrors() as $field => $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?= form_open(base_url('dashboard/admin/updateUser/' . $userData->id_user)) ?>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username', $userData->username) ?>" required>
                        <?php if ($validation->hasError('username')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('username') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control rounded-pill <?= $validation->hasError('password') ? 'is-invalid' : '' ?>" id="password" name="password">
                        <div class="form-text">Isi jika ingin mengubah password. Minimal 6 karakter.</div>
                        <?php if ($validation->hasError('password')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control rounded-pill <?= $validation->hasError('confirm_password') ? 'is-invalid' : '' ?>" id="confirm_password" name="confirm_password">
                        <?php if ($validation->hasError('confirm_password')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('confirm_password') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="level" class="form-label">Level Pengguna</label>
                        <select class="form-select rounded-pill <?= $validation->hasError('level') ? 'is-invalid' : '' ?>" id="level" name="level" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="admin" <?= old('level', $userData->level) == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="guru" <?= old('level', $userData->level) == 'guru' ? 'selected' : '' ?>>Guru Pembimbing</option>
                            <option value="siswa" <?= old('level', $userData->level) == 'siswa' ? 'selected' : '' ?>>Siswa</option>
                        </select>
                        <?php if ($validation->hasError('level')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('level') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Simpan Perubahan</button>
                        <a href="<?= base_url('dashboard/admin/users'); ?>" class="btn btn-secondary btn-lg rounded-pill mt-2">Batal</a>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
