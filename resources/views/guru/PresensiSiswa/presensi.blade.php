<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buka Presensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h3>Buka Presensi Siswa</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('guru.presensi-siswa.store') }}" method="POST" class="row g-3">
        @csrf
        <div class="col-md-4">
            <label>Mata Pelajaran</label>
            <select name="mapel_id" class="form-select" required>
                @foreach ($mapel as $m)
                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control" placeholder="Contoh: 9A" required>
        </div>
        <div class="col-md-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="col-md-2 d-grid align-items-end">
            <button type="submit" class="btn btn-success">Buka Presensi</button>
        </div>
    </form>
</div>
</body>
</html>
