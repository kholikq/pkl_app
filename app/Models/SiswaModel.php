<?php namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table      = 'siswa'; // Nama tabel database Anda
    protected $primaryKey = 'nisn';  // Primary key tabel Anda

    protected $useAutoIncrement = false; // Karena NISN VARCHAR
    protected $returnType     = 'object'; // Atau 'array'
    protected $useSoftDeletes = false; // Jika Anda tidak menggunakan soft delete

    // Kolom yang boleh diisi/diupdate (sesuai form sederhana)
    // PASTIKAN 'id_user' ADA DI SINI
    protected $allowedFields = [
        'nama_siswa', 'kelas', 'jurusan', 'alamat_siswa', 'no_hp_siswa', 'email_siswa', 'id_user'
    ];

    // Dates
    protected $useTimestamps = true; // Menggunakan created_at dan updated_at
    protected $dateFormat    = 'datetime'; // Format kolom tanggal di DB Anda
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at'; // Jika menggunakan soft delete

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
