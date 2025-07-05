<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Nama tabel database yang terkait dengan model ini
    protected $table      = 'users';
    // Primary key untuk tabel ini
    protected $primaryKey = 'id_user';

    // Apakah primary key auto-increment?
    protected $useAutoIncrement = true;
    // Tipe data yang akan dikembalikan oleh metode find() (object atau array)
    protected $returnType     = 'object'; // Atau 'array'
    // Menggunakan soft deletes (kolom 'deleted_at')?
    protected $useSoftDeletes = false;

    // Kolom-kolom yang boleh diisi (mass assignable) saat insert/update
    protected $allowedFields = ['username', 'password', 'level'];

    // Dates
    protected $useTimestamps = true; // Menggunakan created_at dan updated_at
    protected $dateFormat    = 'datetime'; // Format kolom tanggal di DB Anda
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at'; // Hanya jika useSoftDeletes = true

    // Aturan validasi (dapat ditambahkan sesuai kebutuhan)
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Metode kustom untuk mencari user berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
