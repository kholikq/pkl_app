<div class="row">
    <div class="col-12">
        <h1 class="mt-4 mb-4"><?= esc($title); ?></h1>
        <p class="lead">Edit detail data DU/DI di bawah ini.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                Formulir Edit DU/DI: <?= esc($dudiData->nama_dudi); ?> (ID: <?= esc($dudiData->id_dudi); ?>)
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

                <?= form_open(base_url('dashboard/admin/updateDudi/' . $dudiData->id_dudi)) ?>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nama_dudi" class="form-label">Nama DU/DI</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('nama_dudi') ? 'is-invalid' : '' ?>" id="nama_dudi" name="nama_dudi" value="<?= old('nama_dudi', $dudiData->nama_dudi) ?>" required>
                        <?php if ($validation->hasError('nama_dudi')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_dudi') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="alamat_dudi" class="form-label">Alamat DU/DI</label>
                        <textarea class="form-control rounded-pill <?= $validation->hasError('alamat_dudi') ? 'is-invalid' : '' ?>" id="alamat_dudi" name="alamat_dudi"><?= old('alamat_dudi', $dudiData->alamat_dudi) ?></textarea>
                        <?php if ($validation->hasError('alamat_dudi')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('alamat_dudi') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="telepon_dudi" class="form-label">Telepon DU/DI</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('telepon_dudi') ? 'is-invalid' : '' ?>" id="telepon_dudi" name="telepon_dudi" value="<?= old('telepon_dudi', $dudiData->telepon_dudi) ?>">
                        <?php if ($validation->hasError('telepon_dudi')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('telepon_dudi') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="email_dudi" class="form-label">Email DU/DI</label>
                        <input type="email" class="form-control rounded-pill <?= $validation->hasError('email_dudi') ? 'is-invalid' : '' ?>" id="email_dudi" name="email_dudi" value="<?= old('email_dudi', $dudiData->email_dudi) ?>">
                        <?php if ($validation->hasError('email_dudi')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email_dudi') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="referensi_jurusan" class="form-label">Referensi Jurusan</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('referensi_jurusan') ? 'is-invalid' : '' ?>" id="referensi_jurusan" name="referensi_jurusan" value="<?= old('referensi_jurusan', $dudiData->referensi_jurusan) ?>" placeholder="Contoh: RPL, TKJ, MM">
                        <div class="form-text">Pisahkan dengan koma jika lebih dari satu.</div>
                        <?php if ($validation->hasError('referensi_jurusan')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('referensi_jurusan') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Simpan Perubahan</button>
                        <a href="<?= base_url('dashboard/admin/dudi'); ?>" class="btn btn-secondary btn-lg rounded-pill mt-2">Batal</a>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
