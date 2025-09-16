<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\UserModel;

class AdminStudentsController extends BaseController
{
    protected $studentModel;
    protected $userModel;

    public function __construct()
    {
        // Inisialisasi model supaya bisa dipakai di semua method
        $this->studentModel = new StudentModel();
        $this->userModel    = new UserModel();
    }

    public function index()
    {
        $this->authorize(); // cek role Admin
        // Ambil data student + join dengan users
        $data['students'] = $this->studentModel
            ->select('students.id, users.username, users.full_name, students.entry_year')
            ->join('users', 'users.id = students.user_id')
            ->findAll();

        return view('admin/students_index', $data);
    }

    public function new()
    {
        $this->authorize();
        // Tampilkan form tambah mahasiswa
        return view('admin/students_form', [
            'validation' => \Config\Services::validation()
        ]);
    }

    public function create()
    {
        $this->authorize();

        // Validasi input
        $rules = [
            'username'   => 'required|min_length[3]|is_unique[users.username]',
            'full_name'  => 'required',
            'entry_year' => 'required|numeric',
            'password'   => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/admin/students/new')
                ->withInput()
                ->with('validation', $this->validator);
        }

        // Insert user baru
        $userId = $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'full_name'=> $this->request->getPost('full_name'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'Mahasiswa'
        ]);

        // Insert student dengan foreign key ke users
        $this->studentModel->insert([
            'user_id'    => $userId,
            'entry_year' => $this->request->getPost('entry_year')
        ]);

        return redirect()->to('/admin/students')
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        $this->authorize();
        // Ambil data student + user
        $student = $this->studentModel
            ->select('students.id, users.username, users.full_name, students.entry_year')
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
        $this->authorize();

        // Cari student berdasarkan id
        $student = $this->studentModel->find($id);
        if (!$student) throw new \CodeIgniter\Exceptions\PageNotFoundException('Mahasiswa tidak ditemukan.');

        $userId = $student['user_id']; // ambil user terkait

        // Validasi update username agar unik tapi abaikan user sendiri
        $rules = [
            'username'   => "required|min_length[3]|is_unique[users.username,id,{$userId}]",
            'full_name'  => 'required',
            'entry_year' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to("/admin/students/$id/edit")
                ->withInput()
                ->with('validation', $this->validator);
        }

        // Update data user
        $userData = [
            'username'  => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
        ];
        // Kalau ada input password baru → update
        if ($this->request->getPost('password')) {
            $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }
        $this->userModel->update($userId, $userData);

        // Update data student
        $this->studentModel->update($id, [
            'entry_year' => $this->request->getPost('entry_year')
        ]);

        return redirect()->to('/admin/students')
            ->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $studentModel = new \App\Models\StudentModel();
        $userModel = new \App\Models\UserModel();

        $student = $studentModel->find($id);
        if ($student) {
            // Hapus user
            $userModel->delete($student['user_id']);
            // hapus student juga
            $studentModel->delete($id);
        }

        return redirect()->to('/admin/students')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    private function authorize()
    {
        // Proteksi: hanya Admin boleh akses
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/dashboard')
                ->with('error', 'Akses ditolak!')
                ->send();
            exit;
        }
    }
}
