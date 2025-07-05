<?php
// app/Views/ajuan_baru/index.php
// Tampilan untuk halaman Ajuan Baru PKL
?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-file-alt"></i> Form Pengajuan PKL Baru</h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <p class="text-muted">Silakan isi formulir di bawah ini untuk mengajukan permohonan PKL Anda.</p>
            <form action="<?= base_url('simpan-ajuan'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="nisn">NISN <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nisn" name="nisn" value="<?= old('nisn') ?>" required>
                    <small class="form-text text-muted">Nomor Induk Siswa Nasional Anda.</small>
                </div>
                <div class="form-group">
                    <label for="nama_siswa">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="<?= old('nama_siswa') ?>" required>
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="kelas" name="kelas" value="<?= old('kelas') ?>" required>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?= old('jurusan') ?>" required>
                </div>
                <div class="form-group">
                    <label for="id_dudi">Pilih DU/DI Tujuan <span class="text-danger">*</span></label>
                    <select class="form-control" id="id_dudi" name="id_dudi" required>
                        <option value="">-- Pilih DU/DI --</option>
                        <?php
                        // Ambil data DU/DI dari database
                        $dudiModel = new \App\Models\DudiModel();
                        $dudiList = $dudiModel->findAll();
                        foreach ($dudiList as $dudi) {
                            echo '<option value="' . $dudi->id_dudi . '" ' . (old('id_dudi') == $dudi->id_dudi ? 'selected' : '') . '>' . $dudi->nama_dudi . ' (' . $dudi->referensi_jurusan . ')</option>';
                        }
                        ?>
                    </select>
                    <small class="form-text text-muted">Jika DU/DI belum ada, hubungi admin untuk menambahkannya.</small>
                </div>
                <div class="form-group">
                    <label for="surat_permohonan">Unggah Surat Permohonan (PDF/DOC/DOCX, Max 2MB) <span class="text-danger">*</span></label>
                    <input type="file" class="form-control-file" id="surat_permohonan" name="surat_permohonan" required>
                    <small class="form-text text-muted">Surat permohonan yang sudah disetujui Kakomli.</small>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</div>
