<?php
namespace App\Models;

use CodeIgniter\Model;

class BiodataModel extends Model
{
    protected $table = 'biodata';
    protected $primaryKey = 'NIM';
    protected $allowedFields = ['NIM', 'nama_lengkap', 'jenis_kelamin', 'tanggal_lahir'];
    protected $returnType = 'array'; 
}