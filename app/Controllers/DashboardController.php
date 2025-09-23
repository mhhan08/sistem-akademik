<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\StudentModel;
use App\Models\TakeModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $role = session()->get('role');

        if ($role === 'Admin') {
            $studentModel = new StudentModel();
            $courseModel = new CourseModel();

            $data['total_students'] = $studentModel->countAllResults();
            $data['total_courses'] = $courseModel->countAllResults();

        } elseif ($role === 'Mahasiswa') {
            $takeModel = new TakeModel();
            $studentModel = new StudentModel();

            $student = $studentModel->where('user_id', session()->get('userId'))->first();

            if ($student) {
                $enrolledCourses = $takeModel->getCourses($student['id']);
                $data['total_enrolled'] = count($enrolledCourses);

                // Hitung total SKS
                $total_credits = 0;
                foreach ($enrolledCourses as $course) {
                    $total_credits += $course['credits'];
                }
                $data['total_credits'] = $total_credits;
            } else {
                $data['total_enrolled'] = 0;
                $data['total_credits'] = 0;
            }
        }

        return view('dashboard', $data);
    }
}