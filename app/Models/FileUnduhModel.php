<?php namespace App\Models;

use CodeIgniter\Model;

class FileUnduhModel extends Model
{
    // Nama tabel database yang terkait dengan model ini
    protected $table      = 'file_unduh';
    // Primary key untuk tabel ini
    protected $primaryKey = 'id_file';

    // Apakah primary key auto-increment?
    protected $useAutoIncrement = true;
    // Tipe data yang akan dikembalikan oleh metode find() (object atau array)
    protected $returnType     = 'object'; // Atau 'array'
    // Menggunakan soft deletes (kolom 'deleted_at')?
    protected $useSoftDeletes = false;

    // Kolom-kolom yang boleh diisi (mass assignable) saat insert/update
    protected $allowedFields = ['nama_file', 'deskripsi', 'lokasi_file'];

    // Menggunakan kolom timestamps (created_at dan updated_at)?
    protected $useTimestamps = true;
    // Format tanggal untuk kolom timestamps
    protected $dateFormat    = 'datetime';
    // Nama kolom untuk created_at
    protected $createdField  = 'created_at';
    // Nama kolom untuk updated_at
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at'; // Hanya jika useSoftDeletes = true

    // Aturan validasi (dapat ditambahkan sesuai kebutuhan)
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
