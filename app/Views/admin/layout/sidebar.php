<div id="sidebar-wrapper">
    <div class="sidebar-heading">PKL Admin</div>
    <div class="list-group list-group-flush">
        <a href="<?= base_url('dashboard/admin'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'dashboard/admin') ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="<?= base_url('admin/ajuan'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'admin/ajuan') ? 'active' : '' ?>">
            <i class="fas fa-file-alt me-2"></i> Ajuan PKL
        </a>
        <a href="<?= base_url('admin/siswa'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'admin/siswa') ? 'active' : '' ?>">
            <i class="fas fa-user-graduate me-2"></i> Data Siswa
        </a>
        <a href="<?= base_url('admin/dudi'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'admin/dudi') ? 'active' : '' ?>">
            <i class="fas fa-building me-2"></i> Data DU/DI
        </a>
        <a href="<?= base_url('admin/guru'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'admin/guru') ? 'active' : '' ?>">
            <i class="fas fa-chalkboard-teacher me-2"></i> Data Guru
        </a>
        <a href="<?= base_url('admin/users'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'admin/users') ? 'active' : '' ?>">
            <i class="fas fa-users-cog me-2"></i> Manajemen User
        </a>
        <a href="<?= base_url('admin/alur'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'admin/alur') ? 'active' : '' ?>">
            <i class="fas fa-sitemap me-2"></i> Atur Alur PKL
        </a>
        <a href="<?= base_url('admin/files'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'admin/files') ? 'active' : '' ?>">
            <i class="fas fa-download me-2"></i> Kelola File Unduh
        </a>
        <a href="<?= base_url('admin/sertifikat'); ?>" class="list-group-item list-group-item-action <?= (uri_string() == 'admin/sertifikat') ? 'active' : '' ?>">
            <i class="fas fa-certificate me-2"></i> Kelola Sertifikat
        </a>
        <a href="<?= base_url('auth/logout'); ?>" class="list-group-item list-group-item-action">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>
