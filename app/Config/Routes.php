<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rute untuk halaman Home (Landing Page)
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

// Rute untuk Pendaftaran Akun (menggantikan Ajuan Baru di Landing Page)
$routes->get('/auth/register', 'Auth::register'); // Rute baru untuk halaman pendaftaran akun
$routes->post('/auth/register', 'Auth::processRegister'); // Rute untuk memproses pendaftaran akun

// Rute Ajuan Baru (form pengajuan PKL) akan dipindahkan ke dashboard siswa nanti.
// Jadi, rute lama untuk /ajuan_baru dan /ajuan_baru/submit dihapus dari sini.
// $routes->get('/ajuan_baru', 'AjuanBaru::index');
// $routes->post('/ajuan_baru/submit', 'AjuanBaru::submit');
// $routes->post('/ajuan_baru/checkNisn', 'AjuanBaru::checkNisn'); // Ini juga dihapus

// Rute untuk Menu Data (Publik)
$routes->get('/data', 'Data::index'); // Redirect ke data/siswa
$routes->get('/data/siswa', 'Data::siswa'); // Menampilkan data siswa dengan filter tahun & pencarian
$routes->get('/data/dudi', 'Data::dudi');   // Menampilkan data DU/DI dengan paginasi & pencarian
$routes->get('/data/getDudiSuggestions', 'Data::getDudiSuggestions'); // Rute untuk rekomendasi DU/DI (masih digunakan untuk autocomplete)

// Rute untuk Menu Unduh File (Publik)
$routes->get('/unduh_file', 'UnduhFile::index'); // Menampilkan daftar file
$routes->get('/unduh_file/download/(:any)', 'UnduhFile::download/$1'); // Rute untuk mengunduh file

// Rute untuk Menu Sertifikat (Publik)
$routes->get('/sertifikat', 'Sertifikat::index'); // Menampilkan daftar sertifikat dengan filter tahun & pencarian
$routes->get('/sertifikat/download/(:any)', 'Sertifikat::download/$1'); // Rute untuk mengunduh sertifikat (jika diaktifkan di dashboard siswa)

// Rute untuk Menu Login/Auth
$routes->get('/auth/login', 'Auth::login'); // Menampilkan formulir login
$routes->post('/auth/authenticate', 'Auth::authenticate'); // Memproses login
$routes->get('/auth/logout', 'Auth::logout'); // Proses logout

// Rute untuk Dashboard (dilindungi oleh AuthFilter)
// Kita akan menghapus filter 'auth' dari grup luar untuk sementara,
// dan menerapkannya secara individual di dalam grup 'admin' jika diperlukan.
// Ini untuk mengisolasi masalah.
$routes->group('dashboard', function($routes) { // Hapus ['filter' => 'auth'] dari sini
    // Rute dashboard utama berdasarkan level
    $routes->get('admin', 'Dashboard::admin', ['filter' => 'auth:admin']); // Hanya user level 'admin'
    $routes->get('guru', 'Dashboard::guru', ['filter' => 'auth:guru']);   // Hanya user level 'guru'
    $routes->get('siswa', 'Dashboard::siswa', ['filter' => 'auth:siswa']); // Hanya user level 'siswa'

    // Rute untuk modul Admin Dashboard
    // Semua rute di bawah 'admin' di sini akan otomatis dilindungi oleh filter 'auth:admin'
    $routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
        // Manajemen User
        $routes->get('users', 'Dashboard::users'); // Menampilkan daftar user
        $routes->get('users/add', 'Dashboard::addUser'); // Form tambah user
        $routes->post('users/save', 'Dashboard::saveUser'); // Simpan user
        $routes->get('users/edit/(:num)', 'Dashboard::editUser/$1'); // Form edit user
        $routes->post('users/update/(:num)', 'Dashboard::updateUser/$1'); // Update user
        $routes->get('users/delete/(:num)', 'Dashboard::deleteUser/$1'); // Hapus user

        // Manajemen Data Siswa
        $routes->get('siswa', 'Dashboard::siswa'); // Menampilkan daftar siswa
        $routes->get('siswa/add', 'Dashboard::addSiswa'); // Form tambah siswa
        $routes->post('siswa/save', 'Dashboard::saveSiswa'); // Simpan siswa
        $routes->get('siswa/edit/(:any)', 'Dashboard::editSiswa/$1'); // Form edit siswa (NISN sebagai parameter)
        $routes->post('siswa/update/(:any)', 'Dashboard::updateSiswa/$1'); // Update siswa (NISN sebagai parameter)
        $routes->get('siswa/delete/(:any)', 'Dashboard::deleteSiswa/$1'); // Hapus siswa (NISN sebagai parameter)

        // Manajemen Data DU/DI
        $routes->get('dudi', 'Dashboard::dudi'); // Menampilkan daftar DU/DI
        $routes->get('dudi/add', 'Dashboard::addDudi'); // Form tambah DU/DI
        $routes->post('dudi/save', 'Dashboard::saveDudi'); // Simpan DU/DI
        $routes->get('dudi/edit/(:num)', 'Dashboard::editDudi/$1'); // Form edit DU/DI (ID DU/DI sebagai parameter)
        $routes->post('dudi/update/(:num)', 'Dashboard::updateDudi/$1'); // Update DU/DI (ID DU/DI sebagai parameter)
        $routes->get('dudi/delete/(:num)', 'Dashboard::deleteDudi/$1'); // Hapus DU/DI (ID DU/DI sebagai parameter)

        // Manajemen Data Guru
        $routes->get('guru', 'Dashboard::guru'); // Menampilkan daftar guru
        $routes->get('guru/add', 'Dashboard::addGuru'); // Form tambah guru
        $routes->post('guru/save', 'Dashboard::saveGuru'); // Simpan guru
        $routes->get('guru/edit/(:num)', 'Dashboard::editGuru/$1'); // Form edit guru (ID Guru sebagai parameter)
        $routes->post('guru/update/(:num)', 'Dashboard::updateGuru/$1'); // Update guru (ID Guru sebagai parameter) - HAPUS FILTER AUTH DI SINI UNTUK DIAGNOSTIK
        $routes->get('guru/delete/(:num)', 'Dashboard::deleteGuru/$1'); // Hapus guru (ID Guru sebagai parameter)

        // Tambahkan rute untuk modul admin lainnya di sini (contoh)
        // $routes->get('ajuan', 'AdminController::ajuan');
    });
});
