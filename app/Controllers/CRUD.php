<?php


namespace App\Controllers;
use App\Models\BiodataModel;

class CRUD extends BaseController
{
    public function view_create_mhs(){
        return view('create_db_mhs');
    }

    public function create_mhs()
    {
        $model = new BiodataModel();
        $data = [
            'NIM'           => $this->request->getPost('NIM'),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir')
        ];

        $model->insert($data);

        return redirect()->to('/mahasiswa')->with('success', 'Data berhasil disimpan!');
    }

    public function edit($NIM)
    {
        $model = new BiodataModel();
        $mhs = $model->find($NIM);

        if (!$mhs) {
            return redirect()->to('/mahasiswa')->with('error', 'Data tidak ditemukan');
        }

        return view('update_db_mhs', ['mhs' => $mhs]);
    }

    public function update($NIM)
    {
        $model = new BiodataModel();

        $data = [
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir')
        ];

        $model->update($NIM, $data);

        return redirect()->to('/mahasiswa')->with('success', 'Data berhasil diupdate');
    }

    public function delete_mhs($NIM)
    {
        $model = new BiodataModel();
        $data = $model->find($NIM);

        if (!$data) {
            return redirect()->to('/mahasiswa')->with('error', "Data NIM $NIM tidak ditemukan!");
        }

        $model->delete($NIM);
        return redirect()->to('/mahasiswa')->with('success', "Data NIM $NIM berhasil dihapus!");
    }

    public function read_mhs()
    {

        $model = new BiodataModel();

        $data['Mahasiswa'] = $model->findAll();

        return view('read_db_mhs',$data);

    }
}