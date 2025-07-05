<div class="row">
    <div class="col-12">
        <h1 class="mt-4 mb-4">Manajemen Data Guru Pembimbing</h1>
        <p class="lead">Kelola data guru pembimbing PKL di sini.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chalkboard-teacher me-1"></i>
                Daftar Guru Pembimbing
                <a href="<?= base_url('dashboard/admin/guru/add'); ?>" class="btn btn-primary btn-sm float-end">
                    <i class="fas fa-plus me-1"></i> Tambah Guru
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($guruList)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Guru</th>
                                    <th>NIP</th>
                                    <th>Nama Guru</th>
                                    <th>Bidang Keahlian</th>
                                    <th>No. HP</th>
                                    <th>Email</th>
                                    <th>ID User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($guruList as $guru): ?>
                                    <tr>
                                        <td><?= esc($guru->id_guru); ?></td>
                                        <td><?= esc($guru->nip ?? '-'); ?></td>
                                        <td><?= esc($guru->nama_guru); ?></td>
                                        <td><?= esc($guru->bidang_keahlian ?? '-'); ?></td>
                                        <td><?= esc($guru->no_hp_guru ?? '-'); ?></td>
                                        <td><?= esc($guru->email_guru ?? '-'); ?></td>
                                        <td><?= esc($guru->id_user ?? '-'); ?></td>
                                        <td>
                                            <a href="<?= base_url('dashboard/admin/guru/edit/' . $guru->id_guru); ?>" class="btn btn-warning btn-sm text-white">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('dashboard/admin/guru/delete/' . $guru->id_guru); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data guru ini?');">
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
                        Belum ada data guru pembimbing.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
