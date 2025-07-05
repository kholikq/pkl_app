<div class="row">
    <div class="col-12">
        <h1 class="mt-4 mb-4">Manajemen Data Siswa</h1>
        <p class="lead">Kelola data siswa yang terdaftar di sistem.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user-graduate me-1"></i>
                Daftar Siswa
                <a href="<?= base_url('dashboard/admin/siswa/add'); ?>" class="btn btn-primary btn-sm float-end">
                    <i class="fas fa-plus me-1"></i> Tambah Siswa
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($siswaList)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jurusan</th>
                                    <th>No. HP</th>
                                    <th>Email</th>
                                    <th>ID User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($siswaList as $siswa): ?>
                                    <tr>
                                        <td><?= esc($siswa->nisn); ?></td>
                                        <td><?= esc($siswa->nama_siswa); ?></td>
                                        <td><?= esc($siswa->kelas); ?></td>
                                        <td><?= esc($siswa->jurusan); ?></td>
                                        <td><?= esc($siswa->no_hp_siswa ?? '-'); ?></td>
                                        <td><?= esc($siswa->email_siswa ?? '-'); ?></td>
                                        <td><?= esc($siswa->id_user ?? '-'); ?></td>
                                        <td>
                                            <a href="<?= base_url('dashboard/admin/siswa/edit/' . $siswa->nisn); ?>" class="btn btn-warning btn-sm text-white">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('dashboard/admin/siswa/delete/' . $siswa->nisn); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?');">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center" role="alert">
                        Belum ada data siswa.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
