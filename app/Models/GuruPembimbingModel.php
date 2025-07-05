<?php namespace App\Models;

use CodeIgniter\Model;

class GuruPembimbingModel extends Model
{
    // Nama tabel database yang terkait dengan model ini
    protected $table      = 'guru_pembimbing';
    // Primary key untuk tabel ini
    protected $primaryKey = 'id_guru';

    // Apakah primary key auto-increment?
    protected $useAutoIncrement = true;
    // Tipe data yang akan dikembalikan oleh metode find() (object atau array)
    protected $returnType     = 'object'; // Atau 'array'
    // Menggunakan soft deletes (kolom 'deleted_at')?
    protected $useSoftDeletes = false;

    // Kolom-kolom yang boleh diisi (mass assignable) saat insert/update
    protected $allowedFields = ['id_user', 'nip', 'nama_guru', 'bidang_keahlian', 'no_hp_guru', 'email_guru'];

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
