<div class="row">
    <div class="col-12">
        <h1 class="mt-4 mb-4">Manajemen Pengguna</h1>
        <p class="lead">Kelola akun pengguna sistem (Admin, Guru, Siswa) di sini.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-users-cog me-1"></i>
                Daftar Pengguna
                <a href="<?= base_url('admin/users/add'); ?>" class="btn btn-primary btn-sm float-end">
                    <i class="fas fa-plus me-1"></i> Tambah Pengguna
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($usersList)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID User</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th>Dibuat Pada</th>
                                    <th>Diperbarui Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usersList as $user): ?>
                                    <tr>
                                        <td><?= esc($user->id_user); ?></td>
                                        <td><?= esc($user->username); ?></td>
                                        <td><?= esc(ucfirst($user->level)); ?></td>
                                        <td><?= esc($user->created_at); ?></td>
                                        <td><?= esc($user->updated_at); ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/users/edit/' . $user->id_user); ?>" class="btn btn-warning btn-sm text-white">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('admin/users/delete/' . $user->id_user); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
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
                        Belum ada data pengguna.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
