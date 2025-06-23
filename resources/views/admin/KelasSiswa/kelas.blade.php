<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelas Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .card {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-ubah {
            min-width: 80px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center">🧑‍🏫 Manajemen Kelas Siswa</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Nama Lengkap</th>
                                <th>Asal Sekolah</th>
                                <th>Kelas Saat Ini</th>
                                <th>Aksi Ubah Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $index => $s)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $s->nama_lengkap }}</td>
                                    <td>{{ $s->asal_sekolah }}</td>
                                    <td class="text-center">{{ $s->kelas->nama ?? '-' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.kelas-siswa.update', $s->siswa_id) }}" class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <select name="kelas_id" class="form-select me-2">
                                                <option disabled selected>Pilih Kelas</option>
                                                @foreach ($kelas as $k)
                                                    <option value="{{ $k->id }}" {{ $s->kelas_id == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm btn-ubah">
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data siswa</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
