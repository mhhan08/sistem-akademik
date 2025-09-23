<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminCoursesController extends BaseController
{
    protected $courseModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
    }

    // return semua data course
    public function index()
    {
        $data = [
            'courses' => $this->courseModel->findAll()
        ];

        return view('admin/courses_index', $data);
    }

    // return form untuk tambah courses
    public function new()
    {
        return view('admin/courses_form', [
            'validation' => \Config\Services::validation()
        ]);
    }

    // simpan courses baru
    public function create()
    {
        $rules = [
            'course_name' => 'required|min_length[3]',
            'credits'     => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $this->courseModel->save([
            'course_name' => $this->request->getPost('course_name'),
            'credits'     => $this->request->getPost('credits')
        ]);

        return redirect()->to('/admin/courses')
            ->with('success', 'Course berhasil ditambahkan.');
    }

    // form untuk edit courses
    public function edit($id = null)
    {
        $course = $this->courseModel->find($id);

        if (!$course) {
            throw new PageNotFoundException('Course dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('admin/courses_form', [
            'course'     => $course,
            'validation' => \Config\Services::validation()
        ]);
    }

    // updat courses
    public function update($id = null)
    {
        $rules = [
            'course_name' => 'required|min_length[3]',
            'credits'     => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $this->courseModel->update($id, [
            'course_name' => $this->request->getPost('course_name'),
            'credits'     => $this->request->getPost('credits')
        ]);

        return redirect()->to('/admin/courses')
            ->with('success', 'Course berhasil diubah.');
    }

    // Hapus course
    public function delete($id = null)
    {
        $course = $this->courseModel->find($id);

        if (!$course) {
            return redirect()->to('/admin/courses')
                ->with('error', 'Course tidak ditemukan.');
        }

        $this->courseModel->delete($id);

        return redirect()->to('/admin/courses')
            ->with('success', 'Course berhasil dihapus.');
    }
}
