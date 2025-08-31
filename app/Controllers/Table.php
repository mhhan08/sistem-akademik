<?php

namespace App\Controllers;

use App\Models\BiodataModel;
use App\Models\MahasiswaModel;

class Table extends BaseController
{
    public function HTML()
    {
        return view('table_HTML');
    }

    public function table_mhs()
    {
        $model = new BiodataModel();

        $data['mahasiswa'] = $model->findAll(); 

        return view('table_db_loop', $data);
    }

    public function table_link_mhs()
    {
        
        $model = new BiodataModel();

        $data['mahasiswa'] = $model->findAll();

        return view('table_link_detail',$data);
    }

    public function detail_mhs ($nim)
    {
        $model = new BiodataModel();

        $data['mahasiswa'] = $model->where('NIM',$nim)->first();

        if (!$data['mahasiswa']){
           echo "Data mahasiswa dengan nim" . $nim . "tidak ditemukan";
            return ;
        }

        return view('table_detail_mhs',$data);
    }
}
