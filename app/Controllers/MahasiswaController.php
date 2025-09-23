<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\StudentModel;
use App\Models\TakeModel;

class MahasiswaController extends BaseController
{
    /**
     * Menyiapkan data untuk halaman pendaftaran mata kuliah interaktif.
     */
    public function courses()
    {
        if (session()->get('role') !== 'Mahasiswa') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $courseModel = new CourseModel();
        $takeModel = new TakeModel();
        $studentModel = new StudentModel();

        $student = $studentModel->where('user_id', session()->get('userId'))->first();
        if (!$student) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $enrolledCourses = $takeModel->where('student_id', $student['id'])->findColumn('course_id') ?? [];

        $data = [
            'courses' => $courseModel->findAll(),
            'enrolled_course_ids' => $enrolledCourses
        ];

        return view('mahasiswa/courses_index', $data);
    }

    /**
     * Endpoint untuk memproses pendaftaran BANYAK mata kuliah dari JavaScript (AJAX).
     */
    public function processEnrollment()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403, 'Forbidden');
        }
        if (session()->get('role') !== 'Mahasiswa') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Akses ditolak.'])->setStatusCode(401);
        }

        $studentModel = new StudentModel();
        $student = $studentModel->where('user_id', session()->get('userId'))->first();
        if (!$student) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data mahasiswa tidak ditemukan.'])->setStatusCode(404);
        }

        $data = $this->request->getJSON();
        $courseIds = $data->courses ?? [];
        if (empty($courseIds)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak ada mata kuliah yang dipilih.'])->setStatusCode(400);
        }

        $takeModel = new TakeModel();
        $newlyEnrolledCount = 0;
        $alreadyEnrolledCount = 0;

        // Loop melalui setiap mata kuliah yang dipilih
        foreach ($courseIds as $courseId) {
            // 1. Cek dulu apakah sudah terdaftar
            $isEnrolled = $takeModel->where([
                'student_id' => $student['id'],
                'course_id'  => $courseId
            ])->first();

            // 2. Jika BELUM terdaftar, maka insert
            if (!$isEnrolled) {
                $dataToInsert = [
                    'student_id'  => $student['id'],
                    'course_id'   => $courseId,
                    'enroll_date' => date('Y-m-d H:i:s'),
                ];
                $takeModel->insert($dataToInsert);
                $newlyEnrolledCount++; // Tambah hitungan yang berhasil
            } else {
                // 3. Jika SUDAH terdaftar, lewati dan hitung
                $alreadyEnrolledCount++;
            }
        }

        // 4. Buat pesan respon yang dinamis berdasarkan hasil
        if ($newlyEnrolledCount > 0 && $alreadyEnrolledCount == 0) {
            // Semua berhasil
            return $this->response->setJSON(['status' => 'success', 'message' => "Berhasil mendaftar $newlyEnrolledCount mata kuliah baru!"]);
        } elseif ($newlyEnrolledCount == 0 && $alreadyEnrolledCount > 0) {
            // Tidak ada yang baru, semua duplikat
            return $this->response->setJSON(['status' => 'error', 'message' => "Gagal, semua mata kuliah yang Anda pilih sudah diambil sebelumnya."]);
        } elseif ($newlyEnrolledCount > 0 && $alreadyEnrolledCount > 0) {
            // Sebagian berhasil, sebagian duplikat
            return $this->response->setJSON(['status' => 'success', 'message' => "Berhasil mendaftar $newlyEnrolledCount mata kuliah baru. $alreadyEnrolledCount lainnya sudah Anda ambil sebelumnya."]);
        } else {
            // Kasus aneh jika tidak ada yang dipilih
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak ada mata kuliah yang diproses.']);
        }
    }

    public function myCourses()
    {
        // ... (method ini tidak berubah dan berfungsi untuk halaman "Mata Kuliah Saya")
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
        $enrolledCourses = $takeModel->getCourses($student['id']);
        $totalCredits = 0;
        foreach ($enrolledCourses as $course) {
            $totalCredits += $course['credits'];
        }
        $data = [
            'enrolled_courses' => $enrolledCourses,
            'total_credits'    => $totalCredits
        ];
        return view('mahasiswa/myCourses', $data);
    }
}