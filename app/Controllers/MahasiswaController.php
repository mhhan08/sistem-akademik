<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\StudentModel;
use App\Models\TakeModel;

class MahasiswaController extends BaseController
{

    public function courses()
    {
        // Proteksi Role
        if (session()->get('role') !== 'Mahasiswa') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $courseModel = new CourseModel();
        $data['courses'] = $courseModel->findAll();

        return view('mahasiswa/courses_index', $data);
    }

    public function enroll($course_id)
    {
        // Proteksi Role
        if (session()->get('role') !== 'Mahasiswa') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        // 1. Dapatkan user_id dari session
        $user_id = session()->get('userId');

        // 2. Cari id dari tabel 'students' berdasarkan user_id
        $studentModel = new StudentModel();
        $student = $studentModel->where('user_id', $user_id)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        $student_id = $student['id'];

        // 3. Simpan ke tabel 'takes'
        $takeModel = new TakeModel();
        $dataToInsert = [
            'student_id'  => $student_id,
            'course_id'   => $course_id,
        ];

        // Cek apakah sudah pernah diambil
        $isEnrolled = $takeModel->where($dataToInsert)->first();
        if ($isEnrolled) {
            return redirect()->back()->with('error', 'Mata kuliah ini sudah Anda ambil.');
        }

        // Tambahkan tanggal enroll saat ini
        $dataToInsert['enroll_date'] = date('Y-m-d');
        $takeModel->insert($dataToInsert);

        return redirect()->to(site_url('mahasiswa/courses'))->with('success', 'Berhasil mengambil mata kuliah!');
    }

    public function myCourses()
    {
        if (session()->get('role') !== 'Mahasiswa') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $studentModel = new StudentModel();
        $takeModel = new TakeModel();
        $userId = session()->get('userId');

        $student = $studentModel->where('user_id', $userId)->first();

        if (!$student) {
            return redirect()->to('/dashboard')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $data['enrolled_courses'] = $takeModel->getCourses($student['id']);

        return view('mahasiswa/myCourses', $data);
    }
}