<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $courses_data = [
            ['course_name' => 'Dasar Pemrograman', 'credits' => 3],
            ['course_name' => 'Struktur Data', 'credits' => 3],
            ['course_name' => 'Basis Data', 'credits' => 4],
            ['course_name' => 'Proyek Perangkat Lunak', 'credits' => 4],
        ];

        $this->db->table('courses')->insertBatch($courses_data);
    }
}