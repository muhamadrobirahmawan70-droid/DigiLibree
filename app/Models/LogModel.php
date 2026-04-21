<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table      = 'log_aktivitas';
    protected $primaryKey = 'id_log';
    protected $allowedFields = ['id_user', 'aksi', 'keterangan', 'ip_address', 'created_at'];

    public function getLogs()
{
    return $this->select('logs.*, users.username') // Ambil semua data log + username dari tabel user
                ->join('users', 'users.id_user = logs.id_user') // Hubungkan lewat ID User
                ->orderBy('logs.created_at', 'DESC')
                ->findAll();
}
}