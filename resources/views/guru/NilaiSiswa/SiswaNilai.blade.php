<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengumpulan Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 0.35rem 0.35rem 0 0 !important;
        }

        .table thead {
            background-color: var(--primary-color);
            color: white;
            position: sticky;
            top: 0;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.05em;
            padding: 1rem;
        }

        .table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }

        .badge-status {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4em 0.65em;
        }

        .badge-nilai {
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.35em 0.65em;
        }

        .badge-nilai.bg-success {
            background-color: var(--success-color) !important;
        }

        .badge-nilai.bg-warning {
            background-color: var(--warning-color) !important;
        }

        .badge-nilai.bg-danger {
            background-color: var(--danger-color) !important;
        }

        .file-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--primary-color);
            text-decoration: none;
        }

        .file-link:hover {
            text-decoration: underline;
        }

        .form-nilai {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .form-nilai input {
            width: 70px;
            text-align: center;
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

        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .btn-simpan {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.2s ease;
        }

        .btn-simpan:hover {
            background-color: #3a5bc7;
            border-color: #3a5bc7;
            transform: scale(1.05);
        }

        .jawaban-row {
            background-color: #f8f9fa;
            border-left: 4px solid var(--primary-color);
        }

        .jawaban-content {
            white-space: pre-wrap;
            padding: 1rem;
            background-color: white;
            border-radius: 0.25rem;
            border: 1px solid #dee2e6;
            max-height: 300px;
            overflow-y: auto;
        }

        .status-col {
            width: 120px;
        }

        .nilai-col {
            width: 100px;
        }

        .aksi-col {
            width: 150px;
        }

        .jawaban-toggle {
            cursor: pointer;
            color: var(--primary-color);
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .jawaban-toggle:hover {
            text-decoration: underline;
            color: #3a5bc7;
        }

        .filter-section {
            background-color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .table-responsive {
            max-height: 70vh;
            overflow-y: auto;
        }

        .deadline-passed {
            color: var(--danger-color);
            font-weight: 500;
        }

        .deadline-ok {
            color: var(--success-color);
        }

        @media (max-width: 768px) {
            .table-responsive {
                max-height: none;
            }

            .form-nilai {
                flex-direction: column;
                gap: 0.5rem;
            }

            .form-nilai input {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-white mb-2 mb-md-0">
                    <i class="bi bi-journal-check me-2"></i>Daftar Pengumpulan Tugas Siswa
                </h6>
                <div>
                    <span class="badge bg-light text-dark me-2">
                        Total: {{ $nilaiTugas->count() }}
                    </span>
                    <span class="badge bg-success text-white">
                        Dinilai: {{ $nilaiTugas->where('nilai', '!==', null)->count() }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($nilaiTugas->isEmpty())
                    <div class="empty-state">
                        <i class="bi bi-journal-x"></i>
                        <h5>Belum ada pengumpulan tugas</h5>
                        <p class="text-muted">Siswa belum mengumpulkan tugas apapun atau hasil filter tidak ditemukan.
                        </p>
                        <a href="{{ route('guru.CreateNilai.index') }}" class="btn btn-outline-primary btn-sm mt-3">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Kembali ke Semua Tugas
                        </a>
                    </div>
                @endif
                <div class="filter-section">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small">Tanggal Pengumpulan</label>
                            <input type="date" name="tanggal_pengumpulan" class="form-control form-control-sm"
                                value="{{ request('tanggal_pengumpulan') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Nama Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control form-control-sm"
                                placeholder="Cari nama siswa" value="{{ request('nama_siswa') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Semua Status</option>
                                <option value="dinilai" {{ request('status') == 'dinilai' ? 'selected' : '' }}>Sudah
                                    Dinilai</option>
                                <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum
                                    Dinilai</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <div class="d-flex gap-2 w-100">
                                <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                                    <i class="bi bi-funnel me-1"></i>Filter
                                </button>
                                <a href="{{ route('guru.CreateNilai.index') }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Mata Pelajaran</th>
                                <th>Detail Tugas</th>
                                <th>Jawaban</th>
                                <th class="status-col">Status</th>
                                <th class="nilai-col">Nilai</th>
                                <th class="aksi-col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nilaiTugas as $nt)
                                <!-- Baris Utama -->
                                <tr class="hover-shadow">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="bi bi-person-circle fs-4 text-primary"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $nt->siswa->nama_lengkap }}</strong>
                                                <div class="text-muted small">{{ $nt->siswa->kelas->nama ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-block">{{ $nt->tugas->mapel->nama }}</span>
                                        <small class="text-muted">{{ $nt->tugas->mapel->kode }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $nt->tugas->judul }}</strong>
                                        <div class="small">
                                            <span
                                                class="{{ \Carbon\Carbon::parse($nt->tugas->deadline)->isPast() ? 'deadline-passed' : 'deadline-ok' }}">
                                                Deadline:
                                                {{ \Carbon\Carbon::parse($nt->tugas->deadline)->format('d M Y') }}
                                            </span>
                                            @if ($nt->tanggal_pengumpulan)
                                                <br>
                                                <span class="text-muted">
                                                    Dikirim:
                                                    {{ \Carbon\Carbon::parse($nt->tanggal_pengumpulan)->format('d M Y H:i') }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($nt->file_jawaban)
                                            <a href="{{ asset('storage/' . $nt->file_jawaban) }}" target="_blank"
                                                class="file-link">
                                                <i class="bi bi-file-earmark-arrow-down"></i>
                                                File Jawaban
                                            </a>
                                        @endif

                                        @if ($nt->jawaban_teks)
                                            <div class="mt-2">
                                                <span class="jawaban-toggle" data-bs-toggle="collapse"
                                                    data-bs-target="#jawabanCollapse{{ $nt->id }}">
                                                    <i class="bi bi-text-paragraph me-1"></i>Lihat Jawaban Teks
                                                </span>
                                            </div>
                                        @elseif(!$nt->file_jawaban)
                                            <span class="text-muted fst-italic">Belum ada jawaban</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($nt->nilai !== null)
                                            <span class="badge bg-success badge-status">
                                                <i class="bi bi-check-circle me-1"></i>Telah Dinilai
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark badge-status">
                                                <i class="bi bi-clock me-1"></i>Belum Dinilai
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($nt->nilai !== null)
                                            @php
                                                $badgeClass =
                                                    $nt->nilai >= 80
                                                        ? 'bg-success'
                                                        : ($nt->nilai >= 60
                                                            ? 'bg-warning'
                                                            : 'bg-danger');
                                            @endphp
                                            <span class="badge badge-nilai {{ $badgeClass }}">
                                                {{ $nt->nilai }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('guru.CreateNilai.update', $nt->id) }}" method="POST"
                                            class="form-nilai">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="nilai" class="form-control form-control-sm"
                                                value="{{ $nt->nilai ?? '' }}" min="0" max="100"
                                                placeholder="Nilai" required>
                                            <button type="submit" class="btn btn-sm btn-simpan text-white">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Baris Tambahan untuk Jawaban Teks -->
                                @if ($nt->jawaban_teks)
                                    <tr class="jawaban-row collapse" id="jawabanCollapse{{ $nt->id }}">
                                        <td colspan="7">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">Jawaban Teks dari
                                                    {{ $nt->siswa->nama_lengkap }}</h6>
                                                <div>
                                                    <button class="btn btn-sm btn-outline-secondary"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#jawabanCollapse{{ $nt->id }}">
                                                        <i class="bi bi-x-lg me-1"></i>Tutup
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-primary ms-2"
                                                        onclick="copyToClipboard('jawabanContent{{ $nt->id }}')">
                                                        <i class="bi bi-clipboard me-1"></i>Salin
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="jawaban-content" id="jawabanContent{{ $nt->id }}">
                                                {!! nl2br(e($nt->jawaban_teks)) !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <!-- Pagination -->
                @if ($nilaiTugas->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $nilaiTugas->links('pagination::bootstrap-5') }}
                    </div>
                @endif
                    
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // SweetAlert untuk konfirmasi update nilai
        document.querySelectorAll('.form-nilai').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;

                // Show loading state
                submitButton.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                submitButton.disabled = true;

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message || 'Nilai berhasil diperbarui',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Gagal memperbarui nilai');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: error.message || 'Terjadi kesalahan saat memperbarui nilai'
                        });
                    })
                    .finally(() => {
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                    });
            });
        });

        // Fungsi untuk menyalin teks jawaban
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            const range = document.createRange();
            range.selectNode(element);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Tersalin!',
                        text: 'Jawaban telah disalin ke clipboard',
                        timer: 1000,
                        showConfirmButton: false
                    });
                }
            } catch (err) {
                console.error('Gagal menyalin teks: ', err);
            }

            window.getSelection().removeAllRanges();
        }

        // Auto focus input nilai saat baris dihover
        document.querySelectorAll('.hover-shadow').forEach(row => {
            row.addEventListener('mouseenter', function() {
                const input = this.querySelector('input[name="nilai"]');
                if (input) {
                    input.focus();
                }
            });
        });
    </script>
</body>

</html>
