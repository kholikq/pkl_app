<!-- Container utama untuk halaman -->
<div class="container my-5">
    <div class="row justify-content-center text-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg mt-5 p-5">
                <h1 class="display-5 text-primary mb-4">Pengajuan PKL</h1>
                <p class="lead">Untuk mengajukan Praktik Kerja Lapangan, Anda perlu memiliki akun siswa dan login ke sistem.</p>
                <p>Jika Anda belum memiliki akun, silakan daftar terlebih dahulu. Jika sudah memiliki akun, silakan login untuk melanjutkan.</p>
                <div class="mt-4">
                    <a href="<?= base_url('auth/register'); ?>" class="btn btn-success btn-lg rounded-pill me-3">Daftar Akun Baru</a>
                    <a href="<?= base_url('auth/login'); ?>" class="btn btn-outline-primary btn-lg rounded-pill">Login Siswa</a>
                </div>
            </div>
        </div>
    </div>
</div>
