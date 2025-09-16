<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CourseModel;

class AdminCoursesController extends AdminBaseController
{
    protected $courseModel;

    public function __construct()
    {
        // Inisialisasi model agar bisa dipakai di semua method
        $this->courseModel = new CourseModel();
    }

    public function index()
    {

        // Ambil semua data course dari database
        $data['courses'] = $this->courseModel->findAll();
        // Kirim ke view index
        return view('admin/courses_index', $data);
    }

    public function new()
    {
        // Tampilkan form tambah course, kirim service validasi
        return view('admin/courses_form', [
            'validation' => \Config\Services::validation()
        ]);
    }

    public function create()
    {
        // Aturan validasi input
        $rules = [
            'course_name' => 'required|min_length[3]',
            'credits'     => 'required|numeric'
        ];

        // Jika validasi gagal, balik ke form dengan error message
        if (!$this->validate($rules)) {
            return redirect()->to('/admin/courses/new')
                ->withInput()
                ->with('validation', $this->validator);
        }

        // Simpan data course baru
        $this->courseModel->save([
            'course_name' => $this->request->getPost('course_name'),
            'credits'     => $this->request->getPost('credits')
        ]);

        // Redirect ke daftar dengan pesan sukses
        return redirect()->to('/admin/courses')
            ->with('success', 'Course berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        // Cari course berdasarkan ID
        $course = $this->courseModel->find($id);
        // Jika tidak ada, lempar error 404
        if (!$course) throw new \CodeIgniter\Exceptions\PageNotFoundException('Course tidak ditemukan.');

        // Tampilkan form edit dengan data course
        return view('admin/courses_form', [
            'course'     => $course,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id = null)
    {
        // Aturan validasi
        $rules = [
            'course_name' => 'required|min_length[3]',
            'credits'     => 'required|numeric'
        ];

        // Jika gagal validasi, balik ke form edit
        if (!$this->validate($rules)) {
            return redirect()->to('/admin/courses/'.$id.'/edit')
                ->withInput()
                ->with('validation', $this->validator);
        }

        // Update data course berdasarkan ID
        $this->courseModel->update($id, [
            'course_name' => $this->request->getPost('course_name'),
            'credits'     => $this->request->getPost('credits')
        ]);

        return redirect()->to('/admin/courses')
            ->with('success', 'Course berhasil diubah.');
    }

    public function delete($id = null)
    {
        // Hapus data course
        $this->courseModel->delete($id);
        return redirect()->to('/admin/courses')
            ->with('success', 'Course berhasil dihapus.');
    }
}
