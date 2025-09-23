<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>Ambil Mata Kuliah<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="mb-4">
        <h1 class="h3">Ambil Mata Kuliah</h1>
        <p>Silakan pilih mata kuliah yang ingin Anda ambil semester ini.</p>
    </div>

    <div id="responseMessage"></div>

    <form id="enrollmentForm">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0 fw-bold">Daftar Mata Kuliah Tersedia</h6>
            </div>
            <div class="card-body">
                <div id="courseListContainer" class="mb-3">
                    <p>Memuat daftar mata kuliah...</p>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div class="fw-bold fs-5">
                    Total SKS Dipilih: <span id="totalCredits" class="text-primary">0</span>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Daftarkan Mata Kuliah
                </button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. AMBIL DATA DARI CONTROLLER
            const allCourses = <?= json_encode($courses) ?>;
            const enrolledCourseIds = <?= json_encode($enrolled_course_ids) ?>;

            const container = document.getElementById('courseListContainer');
            const totalCreditsEl = document.getElementById('totalCredits');
            const form = document.getElementById('enrollmentForm');
            const responseMessage = document.getElementById('responseMessage');

            // 2. RENDER DAFTAR MATA KULIAH
            container.innerHTML = '';
            allCourses.forEach(course => {
                const isEnrolled = enrolledCourseIds.includes(parseInt(course.id));
                const div = document.createElement('div');
                div.classList.add('form-check', 'mb-2');
                div.innerHTML = `
            <input class="form-check-input course-checkbox" type="checkbox" value="${course.id}" id="course-${course.id}"
                   data-credits="${course.credits}" ${isEnrolled ? 'disabled checked' : ''}>
            <label class="form-check-label" for="course-${course.id}">
                ${course.course_name} (${course.credits} SKS)
                ${isEnrolled ? '<span class="badge bg-success ms-2">Sudah Diambil</span>' : ''}
            </label>
        `;
                container.appendChild(div);
            });

            // 3. HITUNG TOTAL SKS SECARA DINAMIS
            container.addEventListener('change', (event) => {
                if (event.target.classList.contains('course-checkbox')) {
                    let total = 0;
                    const checkedBoxes = document.querySelectorAll('.course-checkbox:checked:not(:disabled)');
                    checkedBoxes.forEach(box => {
                        total += parseInt(box.dataset.credits);
                    });
                    totalCreditsEl.textContent = total;
                }
            });

            // 4. KIRIM DATA SAAT FORM DISUBMIT
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const selectedCourses = [];
                document.querySelectorAll('.course-checkbox:checked:not(:disabled)').forEach(box => {
                    selectedCourses.push(box.value);
                });

                if (selectedCourses.length === 0) {
                    alert('Anda belum memilih mata kuliah sama sekali.');
                    return;
                }

                responseMessage.innerHTML = `<div class="alert alert-info">Menyimpan data...</div>`;

                try {
                    const response = await fetch('<?= site_url('mahasiswa/process-enroll') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                        },
                        body: JSON.stringify({ courses: selectedCourses })
                    });
                    const result = await response.json();
                    if (result.status === 'success') {
                        responseMessage.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        responseMessage.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
                    }
                } catch (error) {
                    responseMessage.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan koneksi.</div>`;
                }
            });
        });
    </script>
<?= $this->endSection() ?>