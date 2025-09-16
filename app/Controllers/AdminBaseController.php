<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class AdminBaseController extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Cek role
        if (session()->get('role') !== 'Admin') {
            // ambil URL sebelumnya atau dashboard
            $previousUrl = previous_url() ?? site_url('/dashboard');

            // tampilkan pesan eror dan tolak
            session()->setFlashdata('error', 'Akses ditolak');

            // redirect ke url sebelumnya
            $response->redirect($previousUrl);
            $response->send();
            exit;
        }
    }
}
