<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISMADU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #b2a496;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
        }

        .navbar-nav .nav-link:hover {
            background-color: #886e58;
        }

        .table thead {
            background-color: #b2a496;
            color: white;
        }

        .btn-primary {
            background-color: #886e58;
            border: none;
        }

        .btn-primary:hover {
            background-color: #6f5441;
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .modal-content {
            border-radius: 10px;
        }

        .footer {
            background-color: #b2a496;
            color: white;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white" href="#">SISMADU</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon bg-light"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white ms-2" href="{{ route('guru.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white ms-2" href="{{ route('guru.jadwal_ajar.index') }}">Jadwal Mengajar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white ms-2" href="{{ route('guru.tugas.index') }}">Unggah Materi & Tugas</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Nilai Siswa</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <main class="flex-fill">
        <div class="container py-5">
            <h4 class="mb-4">Daftar Tugas</h4>

            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalUploadTugas">Upload
                Tugas</button>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Mapel</th>
                            <th>Tanggal Dibuat</th>
                            <th>type</th>
                            <th>Deadline</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tugas as $item)
                            <tr>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->mapel->nama }}</td>
                                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                <td>{{ ucfirst($item->type) }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->deadline)->format('d-m-Y') }}</td>
                                <td>
                                    @if ($item->file_tugas)
                                        <a href="{{ asset('storage/' . $item->file_tugas) }}" target="_blank">Lihat</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEditTugas{{ $item->id }}">Edit</button>
                                    <form action="{{ route('guru.tugas.destroy', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEditTugas{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <form action="{{ route('guru.tugas.update', $item->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Tugas</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Mata Pelajaran</label>
                                                    <select name="mapel_id" class="form-select" required>
                                                        @foreach ($mapels as $mapel)
                                                            <option value="{{ $mapel->id }}"
                                                                {{ $item->mapel_id == $mapel->id ? 'selected' : '' }}>
                                                                {{ $mapel->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Judul</label>
                                                    <input type="text" name="judul" class="form-control"
                                                    value="{{ $item->judul }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">type</label>

                                                    <select name="type" class="form-select" required>
                                                        <option value="tugas"
                                                            {{ $item->type == 'tugas' ? 'selected' : '' }}>Tugas</option>
                                                        <option value="materi"
                                                            {{ $item->type == 'materi' ? 'selected' : '' }}>Materi</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control">{{ $item->deskripsi }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Ganti File</label>
                                                    <input type="file" name="file_tugas" class="form-control">
                                                    @if ($item->file_tugas)
                                                        <small>File lama: <a
                                                                href="{{ asset('storage/' . $item->file_tugas) }}"
                                                                target="_blank">Lihat</a></small>
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Deadline</label>
                                                    <input type="date" name="deadline" class="form-control"
                                                        value="{{ $item->deadline }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Upload -->
    <div class="modal fade" id="modalUploadTugas" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('guru.tugas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Tugas Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="mapel_id" class="form-select" required>
                                <option value="">-- Pilih Mapel --</option>
                                @foreach ($mapels as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Jenis</label>
                            <select name="type" class="form-select" required>
                                <option value="tugas">Tugas</option>
                                <option value="materi">Materi</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Tugas</label>
                            <input type="file" name="file_tugas" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deadline</label>
                            <input type="date" name="deadline" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto">
        &copy; 2025 <strong>SISMADU</strong> - All rights reserved.
    </footer>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
