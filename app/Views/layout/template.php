<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | Sistem Akademik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('dashboard') ?>">Sistem Akademik</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= site_url('dashboard') ?>">Dashboard</a>
                </li>

                <?php if (session()->get('role') == 'Admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/courses') ?>">Kelola Mata Kuliah</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/students') ?>">Kelola Mahasiswa</a>
                    </li>
                <?php elseif (session()->get('role') == 'Mahasiswa'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mahasiswa/courses') ?>">Ambil Mata Kuliah</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('mahasiswa/myCourses') ?>">Mata Kuliah Saya</a>
                    </li>
                <?php endif; ?>

            </ul>

            <span class="navbar-text">
        Halo, <strong><?= session()->get('fullName') ?></strong>
    </span>
            <a href="<?= site_url('logout') ?>" class="btn btn-danger btn-sm ms-3">Logout</a>
        </div>
    </div>
</nav>

<main class="container mt-4">
    <?= $this->renderSection('content') ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>