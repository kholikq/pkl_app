<?php namespace App\Models;

use CodeIgniter\Model;

class AlurPklModel extends Model
{
    protected $table      = 'alur_pkl';
    protected $primaryKey = 'id_alur';

    protected $useAutoIncrement = true;
    protected $returnType     = 'object'; // Atau 'array'
    protected $useSoftDeletes = false;

    protected $allowedFields = ['judul_alur', 'deskripsi_alur', 'urutan'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}