<div class="row">
    <div class="col-12">
        <h1 class="mt-4 mb-4"><?= esc($title); ?></h1>
        <p class="lead">Isi formulir di bawah untuk menambahkan data siswa baru.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user-plus me-1"></i>
                Formulir Tambah Siswa
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
                // $validation sudah dikirim dari controller
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

                <?= form_open(base_url('dashboard/admin/saveSiswa')) ?>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('nisn') ? 'is-invalid' : '' ?>" id="nisn" name="nisn" value="<?= old('nisn') ?>" required>
                        <?php if ($validation->hasError('nisn')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nisn') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('nama_siswa') ? 'is-invalid' : '' ?>" id="nama_siswa" name="nama_siswa" value="<?= old('nama_siswa') ?>" required>
                        <?php if ($validation->hasError('nama_siswa')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_siswa') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select class="form-select rounded-pill <?= $validation->hasError('kelas') ? 'is-invalid' : '' ?>" id="kelas" name="kelas" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach ($kelasList as $kelas): ?>
                                <option value="<?= esc($kelas->nama_kelas) ?>" <?= old('kelas') == $kelas->nama_kelas ? 'selected' : '' ?>>
                                    <?= esc($kelas->nama_kelas) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($validation->hasError('kelas')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kelas') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <select class="form-select rounded-pill <?= $validation->hasError('jurusan') ? 'is-invalid' : '' ?>" id="jurusan" name="jurusan" required>
                            <option value="">-- Pilih Jurusan --</option>
                            <?php foreach ($jurusanList as $jurusan): ?>
                                <option value="<?= esc($jurusan->nama_jurusan) ?>" <?= old('jurusan') == $jurusan->nama_jurusan ? 'selected' : '' ?>>
                                    <?= esc($jurusan->nama_jurusan) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($validation->hasError('jurusan')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('jurusan') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="alamat_siswa" class="form-label">Alamat Siswa</label>
                        <textarea class="form-control rounded-pill <?= $validation->hasError('alamat_siswa') ? 'is-invalid' : '' ?>" id="alamat_siswa" name="alamat_siswa"><?= old('alamat_siswa') ?></textarea>
                        <?php if ($validation->hasError('alamat_siswa')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('alamat_siswa') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="no_hp_siswa" class="form-label">No. HP Siswa</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('no_hp_siswa') ? 'is-invalid' : '' ?>" id="no_hp_siswa" name="no_hp_siswa" value="<?= old('no_hp_siswa') ?>">
                        <?php if ($validation->hasError('no_hp_siswa')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_hp_siswa') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="email_siswa" class="form-label">Email Siswa</label>
                        <input type="email" class="form-control rounded-pill <?= $validation->hasError('email_siswa') ? 'is-invalid' : '' ?>" id="email_siswa" name="email_siswa" value="<?= old('email_siswa') ?>">
                        <?php if ($validation->hasError('email_siswa')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email_siswa') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="id_user" class="form-label">ID User (Opsional, jika sudah ada akun login)</label>
                        <input type="text" class="form-control rounded-pill <?= $validation->hasError('id_user') ? 'is-invalid' : '' ?>" id="id_user" name="id_user" value="<?= old('id_user') ?>" placeholder="Kosongkan jika belum ada akun login">
                        <div class="form-text">Isi dengan ID User jika siswa sudah memiliki akun login.</div>
                        <?php if ($validation->hasError('id_user')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('id_user') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Simpan Data Siswa</button>
                        <a href="<?= base_url('dashboard/admin/siswa'); ?>" class="btn btn-secondary btn-lg rounded-pill mt-2">Batal</a>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
