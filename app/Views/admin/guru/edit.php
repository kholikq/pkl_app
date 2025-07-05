<div class="row">
    <div class="col-12">
        <h1 class="mt-4 mb-4"><?= esc($title); ?></h1>
        <p class="lead">Edit detail data guru pembimbing di bawah ini.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                Formulir Edit Guru: <?= esc($guruData->nama_guru); ?> (ID: <?= esc($guruData->id_guru); ?>)
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

                <?= form_open(base_url('dashboard/admin/updateGuru/' . $guruData->id_guru)) ?>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('nip') ? 'is-invalid' : '' ?>" id="nip" name="nip" value="<?= old('nip', $guruData->nip) ?>">
                        <?php if ($validation->hasError('nip')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nip') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="nama_guru" class="form-label">Nama Guru</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('nama_guru') ? 'is-invalid' : '' ?>" id="nama_guru" name="nama_guru" value="<?= old('nama_guru', $guruData->nama_guru) ?>" required>
                        <?php if ($validation->hasError('nama_guru')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_guru') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="bidang_keahlian" class="form-label">Bidang Keahlian</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('bidang_keahlian') ? 'is-invalid' : '' ?>" id="bidang_keahlian" name="bidang_keahlian" value="<?= old('bidang_keahlian', $guruData->bidang_keahlian) ?>" placeholder="Contoh: RPL, TKJ">
                        <?php if ($validation->hasError('bidang_keahlian')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('bidang_keahlian') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="no_hp_guru" class="form-label">No. HP Guru</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('no_hp_guru') ? 'is-invalid' : '' ?>" id="no_hp_guru" name="no_hp_guru" value="<?= old('no_hp_guru', $guruData->no_hp_guru) ?>">
                        <?php if ($validation->hasError('no_hp_guru')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_hp_guru') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="email_guru" class="form-label">Email Guru</label>
                        <input type="email" class="form-control rounded-pill <?= $validation->hasError('email_guru') ? 'is-invalid' : '' ?>" id="email_guru" name="email_guru" value="<?= old('email_guru', $guruData->email_guru) ?>">
                        <?php if ($validation->hasError('email_guru')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email_guru') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="id_user" class="form-label">ID User (Opsional, jika sudah ada akun login)</label>
                        <select class="form-select rounded-pill <?= $validation->hasError('id_user') ? 'is-invalid' : '' ?>" id="id_user" name="id_user">
                            <option value="">-- Pilih ID User (Level Guru) --</option>
                            <?php foreach ($usersList as $userItem): ?>
                                <option value="<?= esc($userItem->id_user) ?>" <?= old('id_user', $guruData->id_user) == $userItem->id_user ? 'selected' : '' ?>>
                                    <?= esc($userItem->id_user) ?> - <?= esc($userItem->username) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Pilih ID User jika guru ini sudah memiliki akun login.</div>
                        <?php if ($validation->hasError('id_user')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('id_user') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Simpan Perubahan</button>
                        <a href="<?= base_url('dashboard/admin/guru'); ?>" class="btn btn-secondary btn-lg rounded-pill mt-2">Batal</a>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
