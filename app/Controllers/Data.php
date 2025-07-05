<?php namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\DudiModel; // Pastikan menggunakan backslash (\)
use App\Models\AjuanPklModel; // Pastikan menggunakan backslash (\)
use App\Models\PenempatanPklModel; // Pastikan menggunakan backslash (\)
use App\Models\GuruPembimbingModel; // Pastikan menggunakan backslash (\)

class Data extends BaseController
{
    // Properti untuk menyimpan instance dari Model
    protected $siswaModel;
    protected $dudiModel;
    protected $ajuanPklModel;
    protected $penempatanPklModel;
    protected $guruPembimbingModel;

    // Konstruktor untuk menginisialisasi Model
    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->dudiModel = new DudiModel();
        $this->ajuanPklModel = new AjuanPklModel();
        $this->guruPembimbingModel = new GuruPembimbingModel();
        $this->penempatanPklModel = new PenempatanPklModel();
    }

    // Metode default untuk /data, akan me-redirect ke data siswa
    public function index()
    {
        return redirect()->to(base_url('data/siswa'));
    }

    // Metode untuk menampilkan Data Siswa (yang sudah diverifikasi)
    public function siswa()
    {
        // Mengambil tahun dari parameter GET 'tahun', jika tidak ada, gunakan tahun saat ini
        $selectedYear = $this->request->getGet('tahun') ?? date('Y');
        $data['selectedYear'] = $selectedYear; // Kirim tahun terpilih ke view

        // Mengambil parameter pencarian
        $searchQuery = $this->request->getGet('q'); // Parameter 'q' untuk query pencarian
        $data['searchQuery'] = $searchQuery; // Kirim query pencarian ke view

        // Membangun query dasar untuk data siswa yang sudah diverifikasi
        $builder = $this->siswaModel
                        ->select('siswa.nisn, siswa.nama_siswa, siswa.kelas, siswa.jurusan,
                                  dudi.nama_dudi, dudi.alamat_dudi,
                                  guru_pembimbing.nama_guru, guru_pembimbing.bidang_keahlian,
                                  ajuan_pkl.tanggal_pengajuan,
                                  penempatan_pkl.tanggal_mulai_pkl, penempatan_pkl.tanggal_selesai_pkl')
                        ->join('ajuan_pkl', 'ajuan_pkl.nisn = siswa.nisn')
                        ->join('penempatan_pkl', 'penempatan_pkl.id_ajuan = ajuan_pkl.id_ajuan', 'left')
                        ->join('dudi', 'dudi.id_dudi = ajuan_pkl.id_dudi', 'left')
                        ->join('guru_pembimbing', 'guru_pembimbing.id_guru = penempatan_pkl.id_guru', 'left')
                        ->where('ajuan_pkl.status_verifikasi', 'disetujui') // Hanya siswa yang diverifikasi admin
                        ->where('YEAR(ajuan_pkl.tanggal_pengajuan)', $selectedYear); // Filter berdasarkan tahun pengajuan

        // Terapkan pencarian jika ada query
        if (!empty($searchQuery)) {
            $builder->groupStart()
                    ->like('siswa.nisn', $searchQuery)
                    ->orLike('siswa.nama_siswa', $searchQuery)
                    ->groupEnd();
        }

        // Terapkan paginasi menggunakan pengaturan default dari Config/Pager.php
        $data['siswaData'] = $builder->paginate(); // Menggunakan default perPage dari Config/Pager.php
        $data['pager'] = $this->siswaModel->pager; // Ambil object pager

        // Memuat tampilan header, data siswa, dan footer
        echo view('layout/header', $data);
        echo view('data/siswa', $data);
        echo view('layout/footer', $data);
    }

    // Metode untuk menampilkan Data DU/DI
    public function dudi()
    {
        // Mengambil parameter pencarian
        $searchQuery = $this->request->getGet('q'); // Parameter 'q' untuk query pencarian
        $data['searchQuery'] = $searchQuery; // Kirim query pencarian ke view

        // Mengambil parameter halaman saat ini untuk paginasi
        // $page = $this->request->getGet('page') ?? 1; // Tidak diperlukan lagi untuk paginasi sisi server
        $perPage = config('Pager')->perPage; // Ambil nilai perPage dari konfigurasi Pager

        // Membangun query dasar untuk data DU/DI
        $builder = $this->dudiModel;

        // Terapkan pencarian jika ada query
        if (!empty($searchQuery)) {
            $builder->like('nama_dudi', $searchQuery); // Pencarian berdasarkan nama_dudi
        }

        // Terapkan paginasi
        $data['dudiList'] = $builder->paginate($perPage); // Menggunakan default perPage dari Config/Pager.php
        $data['pager'] = $this->dudiModel->pager; // Ambil object pager

        // Memuat tampilan header, data DU/DI, dan footer
        echo view('layout/header', $data);
        echo view('data/dudi', $data);
        echo view('layout/footer', $data);
    }

    // Metode baru untuk mendapatkan rekomendasi DU/DI (untuk autocomplete)
    public function getDudiSuggestions()
    {
        $term = $this->request->getGet('term'); // Ambil term pencarian dari request AJAX

        if (strlen($term) < 3) {
            return $this->response->setJSON([]); // Kembalikan array kosong jika term kurang dari 3 karakter
        }

        // Cari DU/DI yang namanya mirip dengan term
        $suggestions = $this->dudiModel
                            ->select('nama_dudi')
                            ->like('nama_dudi', $term, 'after') // Cari yang dimulai dengan term
                            ->limit(10) // Batasi jumlah rekomendasi
                            ->findAll();

        $results = [];
        foreach ($suggestions as $dudi) {
            $results[] = $dudi->nama_dudi; // Ambil hanya nama DU/DI
        }

        return $this->response->setJSON($results); // Kembalikan dalam format JSON
    }
}
