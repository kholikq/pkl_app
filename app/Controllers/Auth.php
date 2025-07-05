<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SiswaModel; // Tambahkan ini untuk memverifikasi NISN
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;
    protected $siswaModel; // Tambahkan ini

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->siswaModel = new SiswaModel(); // Inisialisasi
        helper(['form', 'url', 'session']);
    }

    // Metode untuk menampilkan formulir login
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard/' . session()->get('level')));
        }

        echo view('layout/header');
        echo view('auth/login');
        echo view('layout/footer');
    }

    // Metode untuk memproses autentikasi login
    public function authenticate()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user->password)) {
            $ses_data = [
                'id_user'    => $user->id_user,
                'username'   => $user->username,
                'level'      => $user->level,
                'isLoggedIn' => TRUE
            ];
            session()->set($ses_data);

            return redirect()->to(base_url('dashboard/' . $user->level));
        } else {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }
    }

    // Metode untuk menampilkan formulir pendaftaran akun baru
    public function register()
    {
        echo view('layout/header');
        echo view('auth/register'); // Kita akan membuat view ini
        echo view('layout/footer');
    }

    // Metode untuk memproses pendaftaran akun baru
    public function processRegister()
    {
        // Validasi input pendaftaran
        $rules = [
            'nisn' => [
                'rules' => 'required|numeric|min_length[5]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'required' => 'NISN wajib diisi.',
                    'numeric' => 'NISN harus berupa angka.',
                    'min_length' => 'NISN minimal 5 karakter.',
                    'max_length' => 'NISN maksimal 20 karakter.',
                    'is_unique' => 'NISN ini sudah terdaftar. Silakan login atau hubungi admin.' // Pesan khusus untuk is_unique
                ]
            ],
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        // Debugging: Log NISN yang diterima
        log_message('info', 'Attempting to register NISN: ' . $this->request->getPost('nisn'));

        if (! $this->validate($rules)) {
            // Tambahkan logging untuk melihat error validasi
            log_message('error', 'Validation failed in processRegister: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nisn = $this->request->getPost('nisn');
        $password = $this->request->getPost('password');

        // Cek apakah NISN ada di tabel siswa (data admin)
        $siswa = $this->siswaModel->find($nisn);

        if (!$siswa) {
            log_message('error', 'NISN not found in SiswaModel during registration: ' . $nisn);
            return redirect()->back()->withInput()->with('error', 'NISN Anda tidak ditemukan di database siswa. Silakan hubungi admin sekolah.');
        }

        // Jika NISN ditemukan di tabel siswa, buat akun user baru
        $userData = [
            'username' => $nisn,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'level' => 'siswa', // Default level untuk pendaftaran siswa
        ];

        if ($this->userModel->insert($userData)) {
            $id_user_baru = $this->userModel->getInsertID();

            // Hanya update id_user jika belum terisi atau tidak sesuai
            if ($siswa && ($siswa->id_user === null || $siswa->id_user === '')) {
                $this->siswaModel->update($nisn, ['id_user' => $id_user_baru]);
            }

            log_message('info', 'New user registered: ' . $nisn);
            return redirect()->to(base_url('auth/login'))->with('success', 'Pendaftaran akun berhasil! Silakan login dengan NISN Anda sebagai username dan password yang Anda daftarkan.');
        } else {
            log_message('error', 'Failed to insert user data during registration: ' . json_encode($userData));
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat pendaftaran akun. Silakan coba lagi.');
        }
    }

    // Metode untuk logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'))->with('success', 'Anda telah berhasil logout.');
    }
}
