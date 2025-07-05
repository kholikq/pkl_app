<div class="row">
    <div class="col-12">
        <h1 class="mt-4 mb-4">Manajemen Data DU/DI</h1>
        <p class="lead">Kelola data Dunia Usaha/Dunia Industri (DU/DI) di sini.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-building me-1"></i>
                Daftar DU/DI
                <a href="<?= base_url('dashboard/admin/dudi/add'); ?>" class="btn btn-primary btn-sm float-end">
                    <i class="fas fa-plus me-1"></i> Tambah DU/DI
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($dudiList)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID DU/DI</th>
                                    <th>Nama DU/DI</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                    <th>Referensi Jurusan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dudiList as $dudi): ?>
                                    <tr>
                                        <td><?= esc($dudi->id_dudi); ?></td>
                                        <td><?= esc($dudi->nama_dudi); ?></td>
                                        <td><?= esc($dudi->alamat_dudi ?? '-'); ?></td>
                                        <td><?= esc($dudi->telepon_dudi ?? '-'); ?></td>
                                        <td><?= esc($dudi->email_dudi ?? '-'); ?></td>
                                        <td><?= esc($dudi->referensi_jurusan ?? '-'); ?></td>
                                        <td>
                                            <a href="<?= base_url('dashboard/admin/dudi/edit/' . $dudi->id_dudi); ?>" class="btn btn-warning btn-sm text-white">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('dashboard/admin/dudi/delete/' . $dudi->id_dudi); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data DU/DI ini?');">
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
                        Belum ada data DU/DI.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
