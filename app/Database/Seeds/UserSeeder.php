<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel; // Gunakan model untuk kemudahan

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        // Data untuk tabel users
        $users_data = [
            [
                'username'  => 'admin',
                'password'  => password_hash('admin123', PASSWORD_DEFAULT),
                'role'      => 'Admin',
                'full_name' => 'Administrator Utama'
            ],
            [
                'username'  => 'mahasiswa',
                'password'  => password_hash('mahasiswa123', PASSWORD_DEFAULT),
                'role'      => 'Mahasiswa',
                'full_name' => 'Muhammad Hanif'
            ]
        ];

        // Menggunakan insertBatch akan lebih efisien
        $this->db->table('users')->insertBatch($users_data);

        // Ambil data user mahasiswa yang baru saja dimasukkan
        $mahasiswaUser = $userModel->where('username', 'mahasiswa')->first();

        // Pastikan user mahasiswa ditemukan
        if ($mahasiswaUser) {
            // Data untuk tabel students
            $students_data = [
                'user_id'    => $mahasiswaUser['id'], // Menggunakan ID dari tabel users
                'entry_year' => 2023
            ];
            $this->db->table('students')->insert($students_data);
        }
    }
}