<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Buka Presensi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container py-4">
        <h3 class="mb-4">Form Presensi Siswa</h3>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Nama Guru --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Guru:</label>
            <div>{{ auth()->user()->name ?? 'Tidak diketahui' }}</div>
        </div>

        {{-- Form Presensi --}}
        <form action="{{ route('guru.presensi-siswa.store') }}" method="POST">
            @csrf

            {{-- Mata Pelajaran --}}
            <div class="mb-3">
                <label for="mapel_id" class="form-label">Mata Pelajaran</label>
                <select name="mapel_id" id="mapel_id" class="form-select" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach ($mapel as $m)
                        <option value="{{ $m->id }}">
                            {{ $m->nama }}
                            @if ($m->kelas && $m->kelas->nama_kelas)
                                (Kelas: {{ $m->kelas->nama_kelas }})
                            @else
                                (Kelas: Tidak tersedia)
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('mapel_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kelas --}}
            <div class="mb-3">
                <label for="kelas_id" class="form-label">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas ?? $kelas->nama }}</option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Presensi --}}
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                @error('tanggal')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" class="btn btn-primary">Buka Presensi</button>
        </form>
    </div>

</body>

</html>
