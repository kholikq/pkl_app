<?php namespace App\Models;

use CodeIgniter\Model;

class AjuanPklModel extends Model
{
    protected $table      = 'ajuan_pkl';
    protected $primaryKey = 'id_ajuan';

    protected $useAutoIncrement = true;
    protected $returnType     = 'object'; // Atau 'array'
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nisn', 'id_dudi', 'tanggal_pengajuan', 'status_kakomli',
        'status_verifikasi', 'surat_permohonan', 'catatan_kakomli', 'catatan_admin'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Fungsi untuk mendapatkan statistik ajuan berdasarkan tahun
    public function getAjuanStatsByYear($year)
    {
        return $this->builder()
                    ->select("
                        COUNT(id_ajuan) as total_ajuan,
                        SUM(CASE WHEN status_kakomli = 'disetujui' AND status_verifikasi = 'disetujui' THEN 1 ELSE 0 END) as disetujui_semua,
                        SUM(CASE WHEN status_kakomli = 'menunggu' OR status_verifikasi = 'menunggu' THEN 1 ELSE 0 END) as menunggu_verifikasi,
                        SUM(CASE WHEN status_kakomli = 'ditolak' OR status_verifikasi = 'ditolak' THEN 1 ELSE 0 END) as ditolak_semua
                    ")
                    ->where('YEAR(tanggal_pengajuan)', $year)
                    ->get()
                    ->getRow();
    }
}