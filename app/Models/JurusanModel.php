<?php namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table      = 'jurusan';
    protected $primaryKey = 'id_jurusan';

    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nama_jurusan', 'singkatan'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
