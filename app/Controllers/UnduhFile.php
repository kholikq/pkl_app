<?php namespace App\Controllers;

use App\Models\FileUnduhModel;

class UnduhFile extends BaseController
{
    // Properti untuk menyimpan instance dari Model
    protected $fileUnduhModel;

    // Konstruktor untuk menginisialisasi Model dan helper
    public function __construct()
    {
        $this->fileUnduhModel = new FileUnduhModel();
        helper('download'); // Memuat helper download untuk fungsi force_download()
    }

    // Metode default untuk menampilkan daftar file yang bisa diunduh
    public function index()
    {
        // Mengambil semua data file dari model
        $data['fileList'] = $this->fileUnduhModel->findAll();

        // Memuat tampilan header, daftar file, dan footer
        echo view('layout/header', $data);
        echo view('unduh_file/index', $data);
        echo view('layout/footer', $data);
    }

    // Metode untuk menangani proses unduh file
    // Parameter $fileName akan diambil dari URL (misal: /unduh_file/download/nama_file_anda.pdf)
    public function download($fileName = null)
    {
        if ($fileName === null) {
            // Jika nama file tidak diberikan, redirect atau tampilkan error
            return redirect()->to(base_url('unduh_file'))->with('error', 'Nama file tidak valid untuk diunduh.');
        }

        // Cari informasi file di database berdasarkan lokasi_file
        $fileInfo = $this->fileUnduhModel->where('lokasi_file', $fileName)->first();

        if ($fileInfo) {
            $filePath = ROOTPATH . 'public/uploads/file_unduh/' . $fileInfo->lokasi_file;

            // Pastikan file fisik ada
            if (file_exists($filePath)) {
                // Gunakan helper download untuk memaksa unduh file
                return $this->response->download($filePath, null);
            } else {
                // Jika file tidak ditemukan di server
                return redirect()->to(base_url('unduh_file'))->with('error', 'File yang diminta tidak ditemukan di server.');
            }
        } else {
            // Jika informasi file tidak ditemukan di database
            return redirect()->to(base_url('unduh_file'))->with('error', 'File tidak terdaftar dalam sistem.');
        }
    }
}
