<?php namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\SiswaModel; // Diperlukan untuk statistik siswa dan manajemen siswa
use App\Models\AjuanPklModel; // Diperlukan untuk statistik ajuan PKL
use App\Models\UserModel; // Diperlukan untuk manajemen user
use App\Models\KelasModel; // Diperlukan untuk dropdown kelas di form siswa
use App\Models\JurusanModel; // Diperlukan untuk dropdown jurusan di form siswa
use App\Models\DudiModel; // Diperlukan untuk manajemen DU/DI
use App\Models\GuruPembimbingModel; // Diperlukan untuk manajemen Guru

class Dashboard extends BaseController
{
    protected $siswaModel;
    protected $ajuanPklModel;
    protected $userModel;
    protected $kelasModel;
    protected $jurusanModel;
    protected $dudiModel;
    protected $guruPembimbingModel; // Tambahkan ini

    // Metode inisialisasi controller
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        // Helper yang mungkin dibutuhkan di dashboard
        helper(['form', 'url', 'session']);

        // Inisialisasi model-model
        $this->siswaModel = new SiswaModel();
        $this->ajuanPklModel = new AjuanPklModel();
        $this->userModel = new UserModel();
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
        $this->dudiModel = new DudiModel();
        $this->guruPembimbingModel = new GuruPembimbingModel(); // Inisialisasi
    }

    // Metode untuk menampilkan Dashboard Admin
    public function admin()
    {
        // Data yang akan dikirim ke view
        $data['title'] = 'Dashboard Admin';
        $data['user'] = session()->get(); // Mengambil semua data session user

        // --- Mengambil Statistik Nyata ---
        $currentYear = date('Y');

        // Total Siswa Terdaftar (keseluruhan)
        $data['totalSiswaTerdaftar'] = $this->siswaModel->countAllResults();

        // Statistik Ajuan PKL untuk tahun berjalan
        $statsAjuan = $this->ajuanPklModel->getAjuanStatsByYear($currentYear);
        $data['ajuanMenunggu'] = $statsAjuan->menunggu_verifikasi;
        $data['ajuanDisetujui'] = $statsAjuan->disetujui_semua;

        // Memuat tampilan layout admin
        echo view('admin/layout/header', $data);
        echo view('admin/index', $data); // Konten utama dashboard
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk menampilkan halaman Manajemen User (Read)
    public function users()
    {
        $data['title'] = 'Manajemen Pengguna';
        $data['user'] = session()->get(); // Mengambil data user yang sedang login

        // Mengambil semua data user dari model
        $data['usersList'] = $this->userModel->findAll(); // Mengambil semua user

        echo view('admin/layout/header', $data);
        echo view('admin/users/index', $data); // Tampilan manajemen user
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk menampilkan formulir tambah pengguna baru (Create - Form)
    public function addUser()
    {
        $data['title'] = 'Tambah Pengguna Baru';
        $data['user'] = session()->get(); // Data user yang sedang login
        $data['validation'] = \Config\Services::validation(); // Untuk menampilkan error validasi

        echo view('admin/layout/header', $data);
        echo view('admin/users/add', $data); // Tampilan formulir tambah user
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk memproses penyimpanan pengguna baru (Create - Process)
    public function saveUser()
    {
        // Validasi input
        $rules = [
            'username' => [
                'rules' => 'required|min_length[5]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 5 karakter.',
                    'is_unique' => 'Username ini sudah terdaftar.'
                ]
            ],
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'level' => 'required|in_list[admin,guru,siswa]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $level = $this->request->getPost('level');

        $userData = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT), // Hash password
            'level' => $level,
        ];

        if ($this->userModel->insert($userData)) {
            return redirect()->to(base_url('dashboard/admin/users'))->with('success', 'Pengguna baru berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan pengguna baru. Silakan coba lagi.');
        }
    }

    // Metode untuk menampilkan formulir edit pengguna (Update - Form)
    public function editUser($id_user = null)
    {
        $data['title'] = 'Edit Pengguna';
        $data['user'] = session()->get(); // Data user yang sedang login
        $data['validation'] = \Config\Services::validation(); // Untuk menampilkan error validasi

        $userData = $this->userModel->find($id_user);

        if (empty($userData)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna tidak ditemukan: ' . $id_user);
        }

        $data['userData'] = $userData;

        echo view('admin/layout/header', $data);
        echo view('admin/users/edit', $data); // Tampilan formulir edit user
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk memproses update pengguna (Update - Process)
    public function updateUser($id_user = null)
    {
        // Validasi input
        $rules = [
            'username' => [
                'rules' => 'required|min_length[5]|is_unique[users.username,id_user,' . $id_user . ']', // is_unique dengan pengecualian ID saat ini
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 5 karakter.',
                    'is_unique' => 'Username ini sudah terdaftar untuk pengguna lain.'
                ]
            ],
            'level' => 'required|in_list[admin,guru,siswa]',
        ];

        // Aturan password hanya jika diisi (opsional)
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
            $rules['confirm_password'] = 'required|matches[password]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $level = $this->request->getPost('level');

        $userData = [
            'username' => $username,
            'level' => $level,
        ];

        // Jika password diisi, hash dan tambahkan ke data update
        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        if ($this->userModel->update($id_user, $userData)) {
            return redirect()->to(base_url('dashboard/admin/users'))->with('success', 'Pengguna berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pengguna. Silakan coba lagi.');
        }
    }

    // Metode untuk menghapus pengguna (Delete)
    public function deleteUser($id_user = null)
    {
        if ($id_user === null) {
            return redirect()->to(base_url('dashboard/admin/users'))->with('error', 'ID Pengguna tidak valid.');
        }

        // Pastikan admin tidak menghapus dirinya sendiri
        if ($id_user == session()->get('id_user')) {
            return redirect()->to(base_url('dashboard/admin/users'))->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($this->userModel->delete($id_user)) {
            return redirect()->to(base_url('dashboard/admin/users'))->with('success', 'Pengguna berhasil dihapus.');
        } else {
            return redirect()->to(base_url('dashboard/admin/users'))->with('error', 'Gagal menghapus pengguna. Silakan coba lagi.');
        }
    }

    // --- CRUD untuk Data Siswa ---

    // Metode untuk menampilkan daftar siswa (Read)
    public function siswa()
    {
        $data['title'] = 'Manajemen Data Siswa';
        $data['user'] = session()->get();

        // Mengambil semua data siswa dari model, bisa ditambahkan paginasi dan pencarian nanti
        $data['siswaList'] = $this->siswaModel->findAll();

        echo view('admin/layout/header', $data);
        echo view('admin/siswa/index', $data); // Tampilan manajemen siswa
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk menampilkan formulir tambah siswa baru (Create - Form)
    public function addSiswa()
    {
        $data['title'] = 'Tambah Data Siswa Baru';
        $data['user'] = session()->get();
        $data['validation'] = \Config\Services::validation();
        $data['kelasList'] = $this->kelasModel->findAll(); // Ambil data kelas untuk dropdown
        $data['jurusanList'] = $this->jurusanModel->findAll(); // Ambil data jurusan untuk dropdown

        echo view('admin/layout/header', $data);
        echo view('admin/siswa/add', $data); // Tampilan formulir tambah siswa
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk memproses penyimpanan siswa baru (Create - Process)
    public function saveSiswa()
    {
        // Validasi input
        $rules = [
            'nisn' => [
                'rules' => 'required|numeric|min_length[5]|max_length[20]|is_unique[siswa.nisn]',
                'errors' => [
                    'required' => 'NISN wajib diisi.',
                    'numeric' => 'NISN harus berupa angka.',
                    'min_length' => 'NISN minimal 5 karakter.',
                    'max_length' => 'NISN maksimal 20 karakter.',
                    'is_unique' => 'NISN ini sudah terdaftar.'
                ]
            ],
            'nama_siswa' => 'required|min_length[3]',
            'kelas' => 'required',
            'jurusan' => 'required',
            'alamat_siswa' => 'permit_empty',
            'no_hp_siswa' => 'permit_empty|numeric',
            'email_siswa' => 'permit_empty|valid_email',
            'id_user' => 'permit_empty|numeric', // Opsional, bisa kosong atau diisi jika sudah ada user
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $siswaData = [
            'nisn' => $this->request->getPost('nisn'),
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'kelas' => $this->request->getPost('kelas'),
            'jurusan' => $this->request->getPost('jurusan'),
            'alamat_siswa' => $this->request->getPost('alamat_siswa'),
            'no_hp_siswa' => $this->request->getPost('no_hp_siswa'),
            'email_siswa' => $this->request->getPost('email_siswa'),
            'id_user' => $this->request->getPost('id_user') ?: null, // Set null jika kosong
        ];

        if ($this->siswaModel->insert($siswaData)) {
            return redirect()->to(base_url('dashboard/admin/siswa'))->with('success', 'Data siswa berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data siswa. Silakan coba lagi.');
        }
    }

    // Metode untuk menampilkan formulir edit siswa (Update - Form)
    public function editSiswa($nisn = null)
    {
        $data['title'] = 'Edit Data Siswa';
        $data['user'] = session()->get();
        $data['validation'] = \Config\Services::validation();
        $data['kelasList'] = $this->kelasModel->findAll(); // Ambil data kelas untuk dropdown
        $data['jurusanList'] = $this->jurusanModel->findAll(); // Ambil data jurusan untuk dropdown

        $siswaData = $this->siswaModel->find($nisn);

        if (empty($siswaData)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data siswa tidak ditemukan: ' . $nisn);
        }

        $data['siswaData'] = $siswaData;

        echo view('admin/layout/header', $data);
        echo view('admin/siswa/edit', $data); // Tampilan formulir edit siswa
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk memproses update siswa (Update - Process)
    public function updateSiswa($nisn = null)
    {
        // Validasi input
        $rules = [
            'nama_siswa' => 'required|min_length[3]',
            'kelas' => 'required',
            'jurusan' => 'required',
            'alamat_siswa' => 'permit_empty',
            'no_hp_siswa' => 'permit_empty|numeric',
            'email_siswa' => 'permit_empty|valid_email',
            'id_user' => 'permit_empty|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $siswaData = [
            'nama_siswa' => $this->request->getPost('nama_siswa'),
            'kelas' => $this->request->getPost('kelas'),
            'jurusan' => $this->request->getPost('jurusan'),
            'alamat_siswa' => $this->request->getPost('alamat_siswa'),
            'no_hp_siswa' => $this->request->getPost('no_hp_siswa'),
            'email_siswa' => $this->request->getPost('email_siswa'),
            'id_user' => $this->request->getPost('id_user') ?: null,
        ];

        if ($this->siswaModel->update($nisn, $siswaData)) {
            return redirect()->to(base_url('dashboard/admin/siswa'))->with('success', 'Data siswa berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data siswa. Silakan coba lagi.');
        }
    }

    // Metode untuk menghapus siswa (Delete)
    public function deleteSiswa($nisn = null)
    {
        if ($nisn === null) {
            return redirect()->to(base_url('dashboard/admin/siswa'))->with('error', 'NISN siswa tidak valid.');
        }

        if ($this->siswaModel->delete($nisn)) {
            return redirect()->to(base_url('dashboard/admin/siswa'))->with('success', 'Data siswa berhasil dihapus.');
        } else {
            return redirect()->to(base_url('dashboard/admin/siswa'))->with('error', 'Gagal menghapus data siswa. Silakan coba lagi.');
        }
    }

    // --- CRUD untuk Data DU/DI ---

    // Metode untuk menampilkan daftar DU/DI (Read)
    public function dudi()
    {
        $data['title'] = 'Manajemen Data DU/DI';
        $data['user'] = session()->get();

        // Mengambil semua data DU/DI dari model
        $data['dudiList'] = $this->dudiModel->findAll();

        echo view('admin/layout/header', $data);
        echo view('admin/dudi/index', $data); // Tampilan manajemen DU/DI
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk menampilkan formulir tambah DU/DI baru (Create - Form)
    public function addDudi()
    {
        $data['title'] = 'Tambah Data DU/DI Baru';
        $data['user'] = session()->get();
        $data['validation'] = \Config\Services::validation();

        echo view('admin/layout/header', $data);
        echo view('admin/dudi/add', $data); // Tampilan formulir tambah DU/DI
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk memproses penyimpanan DU/DI baru (Create - Process)
    public function saveDudi()
    {
        $rules = [
            'nama_dudi' => 'required|min_length[3]|is_unique[dudi.nama_dudi]',
            'alamat_dudi' => 'permit_empty',
            'telepon_dudi' => 'permit_empty|numeric',
            'email_dudi' => 'permit_empty|valid_email',
            'referensi_jurusan' => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dudiData = [
            'nama_dudi' => $this->request->getPost('nama_dudi'),
            'alamat_dudi' => $this->request->getPost('alamat_dudi'),
            'telepon_dudi' => $this->request->getPost('telepon_dudi'),
            'email_dudi' => $this->request->getPost('email_dudi'),
            'referensi_jurusan' => $this->request->getPost('referensi_jurusan'),
        ];

        if ($this->dudiModel->insert($dudiData)) {
            return redirect()->to(base_url('dashboard/admin/dudi'))->with('success', 'Data DU/DI berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data DU/DI. Silakan coba lagi.');
        }
    }

    // Metode untuk menampilkan formulir edit DU/DI (Update - Form)
    public function editDudi($id_dudi = null)
    {
        $data['title'] = 'Edit Data DU/DI';
        $data['user'] = session()->get();
        $data['validation'] = \Config\Services::validation();

        $dudiData = $this->dudiModel->find($id_dudi);

        if (empty($dudiData)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data DU/DI tidak ditemukan: ' . $id_dudi);
        }

        $data['dudiData'] = $dudiData;

        echo view('admin/layout/header', $data);
        echo view('admin/dudi/edit', $data); // Tampilan formulir edit DU/DI
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk memproses update DU/DI (Update - Process)
    public function updateDudi($id_dudi = null)
    {
        $rules = [
            'nama_dudi' => 'required|min_length[3]|is_unique[dudi.nama_dudi,id_dudi,' . $id_dudi . ']',
            'alamat_dudi' => 'permit_empty',
            'telepon_dudi' => 'permit_empty|numeric',
            'email_dudi' => 'permit_empty|valid_email',
            'referensi_jurusan' => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dudiData = [
            'nama_dudi' => $this->request->getPost('nama_dudi'),
            'alamat_dudi' => $this->request->getPost('alamat_dudi'),
            'telepon_dudi' => $this->request->getPost('telepon_dudi'),
            'email_dudi' => $this->request->getPost('email_dudi'),
            'referensi_jurusan' => $this->request->getPost('referensi_jurusan'),
        ];

        if ($this->dudiModel->update($id_dudi, $dudiData)) {
            return redirect()->to(base_url('dashboard/admin/dudi'))->with('success', 'Data DU/DI berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data DU/DI. Silakan coba lagi.');
        }
    }

    // Metode untuk menghapus DU/DI (Delete)
    public function deleteDudi($id_dudi = null)
    {
        if ($id_dudi === null) {
            return redirect()->to(base_url('dashboard/admin/dudi'))->with('error', 'ID DU/DI tidak valid.');
        }

        if ($this->dudiModel->delete($id_dudi)) {
            return redirect()->to(base_url('dashboard/admin/dudi'))->with('success', 'Data DU/DI berhasil dihapus.');
        } else {
            return redirect()->to(base_url('dashboard/admin/dudi'))->with('error', 'Gagal menghapus data DU/DI. Silakan coba lagi.');
        }
    }


    // Metode placeholder untuk Dashboard Guru (akan dikembangkan nanti)
    public function guru()
    {
        $data['title'] = 'Manajemen Data Guru Pembimbing';
        $data['user'] = session()->get();

        // Mengambil semua data guru dari model
        $data['guruList'] = $this->guruPembimbingModel->findAll(); // Mengambil semua guru

        echo view('admin/layout/header', $data); // Menggunakan layout admin
        echo view('admin/guru/index', $data); // Tampilan guru
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk menampilkan formulir tambah guru baru (Create - Form)
    public function addGuru()
    {
        $data['title'] = 'Tambah Data Guru Pembimbing';
        $data['user'] = session()->get();
        $data['validation'] = \Config\Services::validation();
        $data['usersList'] = $this->userModel->where('level', 'guru')->findAll(); // Ambil user dengan level guru

        echo view('admin/layout/header', $data);
        echo view('admin/guru/add', $data); // Tampilan formulir tambah guru
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk memproses penyimpanan guru baru (Create - Process)
    public function saveGuru()
    {
        $rules = [
            'nip' => [
                'rules' => 'permit_empty|is_unique[guru_pembimbing.nip]',
                'errors' => [
                    'is_unique' => 'NIP ini sudah terdaftar.'
                ]
            ],
            'nama_guru' => 'required|min_length[3]',
            'bidang_keahlian' => 'permit_empty',
            'no_hp_guru' => 'permit_empty|numeric',
            'email_guru' => 'permit_empty|valid_email',
            'id_user' => 'permit_empty|numeric|is_unique[guru_pembimbing.id_user]', // Pastikan id_user unik
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $guruData = [
            'nip' => $this->request->getPost('nip') ?: null,
            'nama_guru' => $this->request->getPost('nama_guru'),
            'bidang_keahlian' => $this->request->getPost('bidang_keahlian'),
            'no_hp_guru' => $this->request->getPost('no_hp_guru'),
            'email_guru' => $this->request->getPost('email_guru'),
            'id_user' => $this->request->getPost('id_user') ?: null,
        ];

        if ($this->guruPembimbingModel->insert($guruData)) {
            return redirect()->to(base_url('dashboard/admin/guru'))->with('success', 'Data guru berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data guru. Silakan coba lagi.');
        }
    }

    // Metode untuk menampilkan formulir edit guru (Update - Form)
    public function editGuru($id_guru = null)
    {
        $data['title'] = 'Edit Data Guru Pembimbing';
        $data['user'] = session()->get();
        $data['validation'] = \Config\Services::validation();

        $guruData = $this->guruPembimbingModel->find($id_guru);

        if (empty($guruData)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data guru tidak ditemukan: ' . $id_guru);
        }

        $data['guruData'] = $guruData;
        $data['usersList'] = $this->userModel->where('level', 'guru')->findAll(); // Ambil user dengan level guru

        echo view('admin/layout/header', $data);
        echo view('admin/guru/edit', $data); // Tampilan formulir edit guru
        echo view('admin/layout/footer', $data);
    }

    // Metode untuk memproses update guru (Update - Process)
    public function updateGuru($id_guru = null)
    {
        $rules = [
            'nip' => [
                'rules' => 'permit_empty|is_unique[guru_pembimbing.nip,id_guru,' . $id_guru . ']',
                'errors' => [
                    'is_unique' => 'NIP ini sudah terdaftar.'
                ]
            ],
            'nama_guru' => 'required|min_length[3]',
            'bidang_keahlian' => 'permit_empty',
            'no_hp_guru' => 'permit_empty|numeric',
            'email_guru' => 'permit_empty|valid_email',
            'id_user' => [
                'rules' => 'permit_empty|numeric|is_unique[guru_pembimbing.id_user,id_guru,' . $id_guru . ']',
                'errors' => [
                    'is_unique' => 'ID User ini sudah terhubung dengan guru lain.'
                ]
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $guruData = [
            'nip' => $this->request->getPost('nip') ?: null,
            'nama_guru' => $this->request->getPost('nama_guru'),
            'bidang_keahlian' => $this->request->getPost('bidang_keahlian'),
            'no_hp_guru' => $this->request->getPost('no_hp_guru'),
            'email_guru' => $this->request->getPost('email_guru'),
            'id_user' => $this->request->getPost('id_user') ?: null,
        ];

        if ($this->guruPembimbingModel->update($id_guru, $guruData)) {
            return redirect()->to(base_url('dashboard/admin/guru'))->with('success', 'Data guru berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data guru. Silakan coba lagi.');
        }
    }

    // Metode untuk menghapus guru (Delete)
    public function deleteGuru($id_guru = null)
    {
        if ($id_guru === null) {
            return redirect()->to(base_url('dashboard/admin/guru'))->with('error', 'ID Guru tidak valid.');
        }

        if ($this->guruPembimbingModel->delete($id_guru)) {
            return redirect()->to(base_url('dashboard/admin/guru'))->with('success', 'Data guru berhasil dihapus.');
        } else {
            return redirect()->to(base_url('dashboard/admin/guru'))->with('error', 'Gagal menghapus data guru. Silakan coba lagi.');
        }
    }

    // Metode placeholder untuk Dashboard Siswa (akan dikembangkan nanti)
    // public function siswa() { ... } // Dihapus untuk menghindari redeclare
}
