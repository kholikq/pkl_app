<?php namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\AjuanPklModel;
use App\Models\AlurPklModel;

class Home extends BaseController
{
    // Properti untuk menyimpan instance dari Model
    protected $siswaModel;
    protected $ajuanPklModel;
    protected $alurPklModel;

    // Konstruktor untuk menginisialisasi Model
    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->ajuanPklModel = new AjuanPklModel();
        $this->alurPklModel = new AlurPklModel();
    }

    // Metode default untuk menampilkan halaman utama
    public function index()
    {
        // --- Data untuk Statistik ---
        // Mengambil tahun dari parameter GET 'tahun', jika tidak ada, gunakan tahun saat ini
        $selectedYear = $this->request->getGet('tahun') ?? date('Y');
        $data['selectedYear'] = $selectedYear; // Kirim tahun terpilih ke view

        // Total siswa (total keseluruhan, tidak bergantung tahun)
        // Jika Anda ingin total siswa yang terdaftar pada tahun tertentu,
        // Anda perlu menambahkan kolom 'tahun_masuk' atau sejenisnya di tabel siswa
        // Untuk saat ini, ini adalah total siswa di DB.
        $data['totalSiswa'] = $this->siswaModel->countAllResults();

        // Statistik Ajuan PKL untuk tahun yang dipilih
        $data['statsAjuan'] = $this->ajuanPklModel->getAjuanStatsByYear($selectedYear);

        // Total siswa yang sudah mengajukan (unik berdasarkan NISN) untuk tahun yang dipilih
        $data['siswaMengajukan'] = $this->ajuanPklModel
                                        ->distinct(true)
                                        ->select('nisn')
                                        ->where('YEAR(tanggal_pengajuan)', $selectedYear)
                                        ->countAllResults();

        // --- Data untuk Alur Pengajuan PKL ---
        $data['alurPkl'] = $this->alurPklModel->orderBy('urutan', 'ASC')->findAll();

        // Memuat tampilan header, halaman utama, dan footer
        echo view('layout/header', $data);
        echo view('home/index', $data);
        echo view('layout/footer', $data);
    }
}
