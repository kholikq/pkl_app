<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    // Metode yang dijalankan sebelum request
    public function before(RequestInterface $request, $arguments = null)
    {
        // Periksa apakah user sudah login
        if (! session()->get('isLoggedIn')) {
            // Jika belum login, redirect ke halaman login dengan pesan error
            return redirect()->to(base_url('auth/login'))->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // Jika user sudah login, periksa level akses
        $userLevel = session()->get('level');

        // Jika ada argumen (level yang diizinkan)
        if ($arguments !== null) {
            // Jika argumen adalah string tunggal, ubah menjadi array
            if (! is_array($arguments)) {
                $arguments = [$arguments];
            }

            // Periksa apakah level user ada di antara level yang diizinkan
            if (! in_array($userLevel, $arguments)) {
                // Jika level tidak sesuai, redirect ke halaman yang tidak diizinkan atau dashboard
                return redirect()->to(base_url('dashboard/' . $userLevel))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }
        // Jika tidak ada argumen, berarti hanya perlu login (tidak spesifik level)
        // Atau jika level sesuai, lanjutkan request
    }

    // Metode yang dijalankan setelah request (tidak ada implementasi khusus di sini)
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here or not
    }
}
