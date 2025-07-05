<?php namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\AjuanPklModel;
use App\Models\DudiModel;
use App\Models\KelasModel; // Dipertahankan karena data kelas akan tetap dikirim ke view untuk dropdown
use App\Models\JurusanModel; // Dipertahankan karena data jurusan akan tetap dikirim ke view untuk dropdown
use App\Models\UserModel; // Dipertahankan karena model ini mungkin digunakan di controller lain (misal Auth)
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AjuanBaru extends BaseController
{
    protected $siswaModel;
    protected $ajuanPklModel;
    protected $dudiModel;
    protected $kelasModel;
    protected $jurusanModel;
    protected $userModel; // Dipertahankan

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Inisialisasi model-model
        $this->siswaModel = new SiswaModel();
        $this->ajuanPklModel = new AjuanPklModel();
        $this->dudiModel = new DudiModel();
        $this->kelasModel = new KelasModel(); // Inisialisasi untuk dropdown
        $this->jurusanModel = new JurusanModel(); // Inisialisasi untuk dropdown
        $this->userModel = new UserModel(); // Inisialisasi (jika masih ada metode yang membutuhkannya di controller ini)
        helper(['form', 'url']);
    }

    public function index()
    {
        $data['dudiList'] = $this->dudiModel->findAll();
        $data['kelasList'] = $this->kelasModel->findAll(); // Data kelas untuk dropdown
        $data['jurusanList'] = $this->jurusanModel->findAll(); // Data jurusan untuk dropdown

        echo view('layout/header', $data);
        echo view('ajuan_baru/index', $data);
        echo view('layout/footer', $data);
    }

    // Metode checkNisn() DIHAPUS sepenuhnya dari controller ini.

    public function submit()
    {
        // Validasi input
        $rules = [
            'nisn' => [
                'rules' => 'required|numeric|min_length[5]|max_length[20]',
                'errors' => [
                    'required' => 'NISN wajib diisi.',
                    'numeric' => 'NISN harus berupa angka.',
                    'min_length' => 'NISN minimal 5 karakter.',
                    'max_length' => 'NISN maksimal 20 karakter.'
                ]
            ],
            'nama_siswa' => 'required|min_length[3]', // Siswa selalu mengisi ini
            'kelas' => 'required', // Siswa selalu mengisi ini
            'jurusan' => 'required', // Siswa selalu mengisi ini
            'alamat_siswa' => 'permit_empty',
            'no_hp_siswa' => 'permit_empty|numeric',
            'email_siswa' => 'permit_empty|valid_email',
            'id_dudi' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Pilih DU/DI tujuan PKL.',
                    'numeric' => 'ID DU/DI tidak valid.'
                ]
            ],
            'surat_permohonan' => [
                'rules' => 'uploaded[surat_permohonan]|max_size[surat_permohonan,2048]|ext_in[surat_permohonan,pdf,doc,docx]',
                'errors' => [
                    'uploaded' => 'Surat permohonan wajib diunggah.',
                    'max_size' => 'Ukuran file surat permohonan maksimal 2MB.',
                    'ext_in' => 'Format file surat permohonan harus PDF, DOC, atau DOCX.'
                ]
            ],
        ];

        if (! $this->validate($rules))
        {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nisn = $this->request->getPost('nisn');
        $id_dudi = $this->request->getPost('id_dudi');
        $file = $this->request->getFile('surat_permohonan');

        // --- Cek apakah NISN ada di database admin ---
        $siswaExists = $this->siswaModel->find($nisn);
        if (!$siswaExists) {
            // Jika NISN tidak ditemukan di database admin, tolak pengajuan
            return redirect()->back()->withInput()->with('error', 'NISN tidak ditemukan di database. Silakan hubungi admin untuk pendaftaran data siswa.');
        }

        // --- Cek apakah siswa sudah mengajukan dan statusnya masih menunggu ---
        $existingAjuan = $this->ajuanPklModel
                              ->where('nisn', $nisn)
                              ->groupStart()
                                  ->where('status_kakomli', 'menunggu')
                                  ->orWhere('status_verifikasi', 'menunggu')
                              ->groupEnd()
                              ->first();

        if ($existingAjuan) {
            $status_msg = "Status Kakomli: " . ucfirst($existingAjuan->status_kakomli) . ", Status Admin: " . ucfirst($existingAjuan->status_verifikasi);
            return redirect()->to(base_url('ajuan_baru'))->with('error', 'Anda sudah memiliki pengajuan PKL yang sedang menunggu verifikasi. Status: ' . $status_msg . '.');
        }

        // --- Proses update data siswa (jika NISN sudah ada) ---
        // Ini memastikan data siswa di DB terupdate dengan input dari form ajuan
        $siswaDataToUpdate = [
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'kelas' => $this->request->getPost('kelas'),
            'jurusan' => $this->request->getPost('jurusan'),
            'alamat_siswa' => $this->request->getPost('alamat_siswa'),
            'no_hp_siswa' => $this->request->getPost('no_hp_siswa'),
            'email_siswa' => $this->request->getPost('email_siswa'),
        ];
        $this->siswaModel->update($nisn, $siswaDataToUpdate);


        // Proses upload file
        $fileName = $file->getRandomName();
        $uploadPath = ROOTPATH . 'public/uploads/surat_permohonan/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if ($file->isValid() && ! $file->hasMoved())
        {
            $file->move($uploadPath, $fileName);

            $dataAjuan = [
                'nisn'              => $nisn,
                'id_dudi'           => $id_dudi,
                'tanggal_pengajuan' => date('Y-m-d'),
                'status_kakomli'    => 'menunggu',
                'status_verifikasi' => 'menunggu',
                'surat_permohonan'  => $fileName,
            ];

            if ($this->ajuanPklModel->insert($dataAjuan)) {
                return redirect()->to(base_url('ajuan_baru'))->with('success', 'Pengajuan PKL Anda berhasil dikirim dan sedang menunggu verifikasi.');
            } else {
                if (file_exists($uploadPath . $fileName)) {
                    unlink($uploadPath . $fileName);
                }
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data pengajuan. Silakan coba lagi.');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah file surat permohonan: ' . $file->getErrorString());
        }
    }
}
