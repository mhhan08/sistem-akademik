<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\UserModel;

class AdminStudentsController extends AdminBaseController
{
    protected $studentModel;
    protected $userModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->userModel    = new UserModel();
    }

    public function index()
    {
        $data['students'] = $this->studentModel
            ->select('students.id, users.username, users.full_name, students.entry_year, students.user_id')
            ->join('users', 'users.id = students.user_id')
            ->findAll();

        return view('admin/students_index', $data);
    }

    public function new()
    {
        return view('admin/students_form', [
            'validation' => \Config\Services::validation()
        ]);
    }

    public function create()
    {
        $rules = [
            'username'   => 'required|min_length[3]|is_unique[users.username]',
            'full_name'  => 'required',
            'entry_year' => 'required|numeric|exact_length[4]',
            'password'   => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/admin/students/new')
                ->withInput()
                ->with('validation', $this->validator);
        }

        $userId = $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'full_name'=> $this->request->getPost('full_name'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'Mahasiswa'
        ]);

        $this->studentModel->insert([
            'user_id'    => $userId,
            'entry_year' => $this->request->getPost('entry_year')
        ]);

        return redirect()->to('/admin/students')
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        $student = $this->studentModel
            ->select('students.id, students.user_id, users.username, users.full_name, students.entry_year')
            ->join('users', 'users.id = students.user_id')
            ->find($id);

        if (!$student) throw new \CodeIgniter\Exceptions\PageNotFoundException('Mahasiswa tidak ditemukan.');

        return view('admin/students_form', [
            'student'    => $student,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id = null)
    {
        $student = $this->studentModel->find($id);
        if (!$student) throw new \CodeIgniter\Exceptions\PageNotFoundException('Mahasiswa tidak ditemukan.');

        $userId = $student['user_id'];

        $rules = [
            'username'   => "required|min_length[3]|is_unique[users.username,id,{$userId}]",
            'full_name'  => 'required',
            'entry_year' => 'required|numeric|exact_length[4]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to("/admin/students/$id/edit")
                ->withInput()
                ->with('validation', $this->validator);
        }

        $userData = [
            'username'  => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
        ];

        if ($this->request->getPost('password')) {
            $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }
        $this->userModel->update($userId, $userData);

        $this->studentModel->update($id, [
            'entry_year' => $this->request->getPost('entry_year')
        ]);

        return redirect()->to('/admin/students')
            ->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $student = $this->studentModel->find($id);
        if ($student) {
            // Hapus user (data student akan ikut terhapus oleh database
            // karena di migrasi Anda ada 'ON DELETE CASCADE')
            $this->userModel->delete($student['user_id']);
        }

        return redirect()->to('/admin/students')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}