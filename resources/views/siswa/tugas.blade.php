<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .subject-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .subject-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .task-card {
            border-left: 4px solid #0d6efd;
            margin-bottom: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .deadline-badge {
            font-size: 0.8rem;
            padding: 0.35em 0.65em;
        }

        .teacher-info {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .task-description {
            white-space: pre-wrap;
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 5px;
            margin: 1rem 0;
        }

        .file-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .submit-form {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .subject-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }
    </style>
</head>

<body>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Tugas Berdasarkan Mata Pelajaran</h3>
            <span class="badge bg-primary">{{ $mapels->count() }} Mata Pelajaran</span>
        </div>

        @if ($mapels->isEmpty())
            <div class="empty-state">
                <i class="bi bi-journal-x"></i>
                <h5>Tidak ada mata pelajaran</h5>
                <p class="text-muted">Saat ini tidak ada mata pelajaran yang tersedia</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($mapels as $mapel)
                    <div class="col-md-6 col-lg-4">
                        <div class="card subject-card h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0">{{ $mapel->nama }}</h5>
                                    <span
                                        class="badge bg-light text-primary">{{ $tugas->where('mapel_id', $mapel->id)->count() }}
                                        Tugas</span>
                                </div>

                                <div class="mt-auto">
                                    <button class="btn btn-primary w-100" data-bs-toggle="collapse"
                                        data-bs-target="#collapseMapel{{ $mapel->id }}" aria-expanded="false">
                                        <i class="bi bi-list-task me-2"></i>Lihat Tugas
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @foreach ($mapels as $mapel)
            <div class="collapse mt-4" id="collapseMapel{{ $mapel->id }}">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="subject-header">
                            <h4 class="text-primary mb-0">
                                <i class="bi bi-book me-2"></i>{{ $mapel->nama }}
                            </h4>
                            <span class="badge bg-primary rounded-pill">
                                {{ $tugas->where('mapel_id', $mapel->id)->count() }} Tugas
                            </span>
                        </div>

                        @php
                            $tugasList = $tugas->where('mapel_id', $mapel->id);
                        @endphp

                        @if ($tugasList->isEmpty())
                            <div class="empty-state py-4">
                                <i class="bi bi-check-circle"></i>
                                <h5>Tidak ada tugas</h5>
                                <p class="text-muted">Tidak ada tugas untuk mata pelajaran ini</p>
                            </div>
                        @else
                            <div class="task-list">
                                @foreach ($tugasList as $item)
                                    {{-- Debug --}}
                                    Jumlah tugas: {{ count($tugasList) }}
                                    <small>
                                        item-id={{ $item->id }},
                                        jawaban-tersimpan={{ json_encode($jawabanTerkirim) }},
                                        inarray={{ in_array($item->id, $jawabanTerkirim, true) ? 'YES' : 'NO' }}
                                    </small>
                                    @php
                                        $sudahDikumpulkan = in_array($item->id, $jawabanTerkirim);
                                        $status = $sudahDikumpulkan ? 'dikumpulkan' : 'belum dikumpulkan';

                                    @endphp

                                    <div class="card task-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="card-title mb-1">{{ $item->judul }}</h5>
                                                <span
                                                    class="deadline-badge badge {{ \Carbon\Carbon::parse($item->deadline)->isPast() ? 'bg-danger' : 'bg-warning text-dark' }}">
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($item->deadline)->translatedFormat('d M Y') }}
                                                </span>
                                            </div>

                                            <p class="teacher-info mb-3">
                                                <i class="bi bi-person-fill me-1"></i>
                                                {{ $item->guru->nama_lengkap }}
                                            </p>

                                            @if ($item->deskripsi)
                                                <div class="task-description">
                                                    {!! nl2br(e($item->deskripsi)) !!}
                                                </div>
                                            @endif

                                            @if ($item->file_tugas)
                                                <div class="mb-3">
                                                    <span class="fw-semibold me-2">Lampiran:</span>
                                                    <a href="{{ asset('storage/' . $item->file_tugas) }}"
                                                        target="_blank" class="file-link text-decoration-none">
                                                        <i class="bi bi-file-earmark-arrow-down"></i>
                                                        Unduh File Tugas
                                                    </a>
                                                </div>
                                            @endif

                                            @if ($sudahDikumpulkan)
                                                <div class="alert alert-success mt-3">
                                                    <i class="bi bi-check-circle-fill me-2"></i>
                                                    Tugas ini telah dikumpulkan.
                                                </div>
                                            @else
                                                <div class="submit-form">
                                                    <h6 class="mb-3"><i class="bi bi-send-check me-2"></i>Kumpulkan
                                                        Tugas</h6>
                                                    <form action="{{ route('siswa.tugasSiswa.store') }}" method="POST"
                                                        enctype="multipart/form-data" class="submit-task-form">
                                                        @csrf
                                                        <input type="hidden" name="tugas_id"
                                                            value="{{ $item->id }}">

                                                        <div class="mb-3">
                                                            <label for="jawaban{{ $item->id }}"
                                                                class="form-label">Jawaban Teks</label>
                                                            <textarea name="jawaban_teks" id="jawaban{{ $item->id }}" class="form-control" rows="3"
                                                                placeholder="Tulis jawaban Anda di sini (opsional)"></textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="file{{ $item->id }}"
                                                                class="form-label">File Jawaban</label>
                                                            <input type="file" name="file_jawaban"
                                                                id="file{{ $item->id }}" class="form-control"
                                                                accept=".pdf,.doc,.docx,.zip,.rar">
                                                            <div class="form-text">Format file: PDF, DOC/DOCX, atau ZIP
                                                                (maks. 5MB)
                                                            </div>
                                                        </div>

                                                        <div class="d-grid">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="bi bi-cloud-arrow-up me-2"></i>Kirim Jawaban
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Efek hover untuk kartu mata pelajaran
            document.querySelectorAll('.subject-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-5px)';
                    card.style.boxShadow = '0 10px 15px rgba(0, 0, 0, 0.1)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = '';
                    card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                });
            });

            // Autofokus saat collapse dibuka
            document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
                button.addEventListener('click', function() {
                    const target = this.getAttribute('data-bs-target');
                    setTimeout(() => {
                        const textarea = document.querySelector(target + ' textarea');
                        if (textarea) textarea.focus();
                    }, 350);
                });
            });

            // Proses submit tugas via AJAX + validasi file
            document.querySelectorAll('.submit-task-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalButtonText = submitButton.innerHTML;

                    // Validasi ukuran file (maks 2MB)
                    const fileInput = this.querySelector('input[type="file"]');
                    if (fileInput && fileInput.files.length > 0) {
                        const fileSize = fileInput.files[0].size;
                        if (fileSize > 2 * 1024 * 1024) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ukuran File Terlalu Besar',
                                text: 'Ukuran file maksimal 2MB.',
                            });
                            return;
                        }
                    }

                    // Tampilkan loading
                    submitButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm"></span> Mengirim...';
                    submitButton.disabled = true;

                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': @json(csrf_token()),

                                'Accept': 'application/json'
                            }
                        })
                        .then(async response => {
                            const contentType = response.headers.get("content-type");
                            if (contentType && contentType.includes("application/json")) {
                                const data = await response.json();
                                if (response.ok && data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: data.message ||
                                            'Tugas berhasil dikumpulkan.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    this.reset();
                                } else {
                                    throw new Error(data.message ||
                                        'Terjadi kesalahan saat menyimpan tugas.');
                                }
                            } else {
                                throw new Error('Respon server tidak valid.');
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: error.message ||
                                    'Terjadi kesalahan saat mengirim tugas.'
                            });
                        })
                        .finally(() => {
                            submitButton.innerHTML = originalButtonText;
                            submitButton.disabled = false;
                        });
                });
            });

            // SweetAlert untuk session flash message
            const flashSuccess = "{{ session('success') }}";
            const flashError = "{{ session('error') }}";

            if (flashSuccess) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: flashSuccess,
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            if (flashError) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: flashError
                });
            }
        });
    </script>

</body>

</html>
