<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TabelAkademik extends Migration
{
    // app/Database/Migrations/YYYY-MM-DD-######_BuatTabelAkademik.php

    public function up()
    {
        //table user
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => '100'],
            'password' => ['type' => 'VARCHAR', 'constraint' => '255'],
            'full_name' => ['type' => 'VARCHAR', 'constraint' => '150'],
            'role' => ['type' => 'ENUM', 'constraint' => ['Admin', 'Mahasiswa']],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        // Tabel Students
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'entry_year' => ['type' => 'YEAR'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('students');

        // Tabel Courses
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'course_name' => ['type' => 'VARCHAR', 'constraint' => '150'],
            'credits' => ['type' => 'INT', 'constraint' => 2],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('courses');

        // Tabel Takes untuk relasi mahasiswa denhgan course dimana mahasiswa mengambil course
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'student_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'course_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'enroll_date' => ['type' => 'DATE'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('takes');
    }

    public function down()
    {
        $this->forge->dropTable('takes');
        $this->forge->dropTable('courses');
        $this->forge->dropTable('students');
        $this->forge->dropTable('users');
    }
}
