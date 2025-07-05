<?php namespace App\Controllers;

use App\Models\SertifikatModel;
use App\Models\PenempatanPklModel; // Diperlukan untuk join
use App\Models\AjuanPklModel; // Diperlukan untuk join
use App\Models\SiswaModel; // Diperlukan untuk join

class Sertifikat extends BaseController
{
    // Properti untuk menyimpan instance dari Model
    protected $sertifikatModel;
    protected $penempatanPklModel;
    protected $ajuanPklModel;
    protected $siswaModel;

    // Konstruktor untuk menginisialisasi Model
    public function __construct()
    {
        $this->sertifikatModel = new SertifikatModel();
        $this->penempatanPklModel = new PenempatanPklModel();
        $this->ajuanPklModel = new AjuanPklModel();
        $this->siswaModel = new SiswaModel();
        helper('download'); // Memuat helper download jika nanti ada fitur unduh sertifikat
    }

    // Metode default untuk menampilkan daftar sertifikat
    public function index()
    {
        // Mengambil parameter pencarian
        $searchQuery = $this->request->getGet('q'); // Parameter 'q' untuk query pencarian
        $data['searchQuery'] = $searchQuery; // Kirim query pencarian ke view

        // Mengambil tahun dari parameter GET 'tahun', jika tidak ada, gunakan tahun saat ini
        $selectedYear = $this->request->getGet('tahun') ?? date('Y');
        $data['selectedYear'] = $selectedYear; // Kirim tahun terpilih ke view

        // Membangun query dasar untuk data sertifikat beserta informasi siswa dan DU/DI terkait
        $builder = $this->sertifikatModel
                                        ->select('sertifikat.*,
                                                  siswa.nisn, siswa.nama_siswa, siswa.kelas, siswa.jurusan,
                                                  dudi.nama_dudi')
                                        ->join('penempatan_pkl', 'penempatan_pkl.id_penempatan = sertifikat.id_penempatan')
                                        ->join('ajuan_pkl', 'ajuan_pkl.id_ajuan = penempatan_pkl.id_ajuan')
                                        ->join('siswa', 'siswa.nisn = ajuan_pkl.nisn')
                                        ->join('dudi', 'dudi.id_dudi = ajuan_pkl.id_dudi', 'left') // Left join karena id_dudi bisa NULL
                                        ->where('YEAR(sertifikat.tanggal_terbit)', $selectedYear); // Filter berdasarkan tahun terbit

        // Terapkan pencarian jika ada query
        if (!empty($searchQuery)) {
            $builder->groupStart()
                    ->like('siswa.nisn', $searchQuery)
                    ->orLike('siswa.nama_siswa', $searchQuery)
                    ->groupEnd();
        }

        // Terapkan paginasi
        $data['sertifikatList'] = $builder->paginate(); // Menggunakan default perPage dari Config/Pager.php
        $data['pager'] = $this->sertifikatModel->pager; // Ambil object pager

        // Memuat tampilan header, daftar sertifikat, dan footer
        echo view('layout/header', $data);
        echo view('sertifikat/index', $data);
        echo view('layout/footer', $data);
    }

    // Metode untuk mengunduh file sertifikat (jika file_sertifikat disimpan)
    public function download($fileName = null)
    {
        if ($fileName === null) {
            return redirect()->to(base_url('sertifikat'))->with('error', 'Nama file sertifikat tidak valid.');
        }

        // Cari informasi sertifikat di database berdasarkan nama file
        $sertifikatInfo = $this->sertifikatModel->where('file_sertifikat', $fileName)->first();

        if ($sertifikatInfo) {
            $filePath = ROOTPATH . 'public/uploads/sertifikat/' . $sertifikatInfo->file_sertifikat;

            // Pastikan file fisik ada
            if (file_exists($filePath)) {
                // Gunakan helper download untuk memaksa unduh file
                return $this->response->download($filePath, null);
            } else {
                return redirect()->to(base_url('sertifikat'))->with('error', 'File sertifikat tidak ditemukan di server.');
            }
        } else {
            return redirect()->to(base_url('sertifikat'))->with('error', 'Sertifikat tidak terdaftar dalam sistem.');
        }
    }
}
