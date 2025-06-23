<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            border: none;
        }
        .form-select, .form-control {
            border-radius: 30px;
        }
        .btn-success {
            border-radius: 30px;
            padding: 10px 25px;
        }
        .table th {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h3 class="text-center mb-4">📋 Presensi Siswa</h3>

                {{-- Alert sukses --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Form Input Presensi --}}
                <form method="POST" action="{{ route('siswa.store') }}" class="mb-5">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="mapel_id" class="form-label fw-semibold">📚 Mata Pelajaran</label>
                            <select name="mapel_id" class="form-select" required>
                                <option disabled selected>-- Pilih Mapel --</option>
                                @foreach ($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label fw-semibold">📝 Status</label>
                            <select name="status" class="form-select" required>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                                <option value="alfa">Alfa</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="keterangan" class="form-label fw-semibold">💬 Keterangan (Opsional)</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Datang terlambat karena hujan">
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">✅ Kirim Presensi</button>
                    </div>
                </form>

                {{-- Tabel Presensi --}}
                <h5 class="mb-3">Riwayat Presensi Anda:</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($presensi as $p)
                                <tr>
                                    <td>{{ $p->tanggal }}</td>
                                    <td>{{ $p->mapel->nama ?? '-' }}</td>
                                    <td>
                                        <span class="badge
                                            @if($p->status == 'hadir') bg-success
                                            @elseif($p->status == 'izin') bg-primary
                                            @elseif($p->status == 'sakit') bg-warning
                                            @else bg-danger
                                            @endif">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $p->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted">Belum ada data presensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
