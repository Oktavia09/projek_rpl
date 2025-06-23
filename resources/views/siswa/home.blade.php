<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISMADU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pendaftarancasis.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold ms-4" href="#">SISMADU</a>
            <div class="d-flex ms-auto me-4">
                <div class="nav-item nav-link text-white" style="cursor:pointer;" onclick="logout()">Logout</div>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('message'))
            <div class="alert alert-info">{{ session('message') }}</div>
        @endif

        {{-- Jika belum daftar tampilkan Form --}}
        @if (!$dataPpdb)
            <div class="form-container">
                <h3 class="text-center mb-4 fw-bold">Formulir Pendaftaran</h3>

                <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            @foreach (['nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'nisn'] as $field)
                                <div class="mb-3">
                                    <label>{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                                    <input type="{{ $field == 'tanggal_lahir' ? 'date' : 'text' }}"
                                        name="{{ $field }}"
                                        class="form-control @error($field) is-invalid @enderror"
                                        value="{{ old($field) }}" required>
                                    @error($field)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin"
                                    class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option disabled selected>Pilih</option>
                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @foreach (['asal_sekolah', 'nomor_telepon'] as $field)
                                <div class="mb-3">
                                    <label>{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                                    <input type="text" name="{{ $field }}"
                                        class="form-control @error($field) is-invalid @enderror"
                                        value="{{ old($field) }}" required>
                                    @error($field)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach

                            <div class="mb-3">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3">Upload & Nilai</h5>

                    <div class="mb-3">
                        <label>Upload Dokumen Rapor</label>
                        <input type="file" name="dokumen_rapor"
                            class="form-control @error('dokumen_rapor') is-invalid @enderror"
                            accept=".pdf,.jpg,.jpeg,.png" required>
                        @error('dokumen_rapor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        @foreach ([
        'nilai_matematika' => 'Matematika',
        'nilai_ipa' => 'IPA',
        'nilai_ips' => 'IPS',
        'nilai_bahasa_indonesia' => 'Bahasa Indonesia',
        'nilai_bahasa_inggris' => 'Bahasa Inggris',
    ] as $field => $label)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Nilai {{ $label }}</label>
                                    <input type="number" name="{{ $field }}"
                                        class="form-control @error($field) is-invalid @enderror"
                                        value="{{ old($field) }}" required>
                                    @error($field)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Kirim Formulir</button>
                    </div>
                </form>
            </div>
        @else
            {{-- Jika sudah daftar tampilkan data --}}
            <div class="container mt-5">
                <h2 class="text-center mb-4">Dashboard Siswa</h2>
                <div class="card mb-4">
                    <div class="card-header">Data Pendaftaran</div>
                    <div class="card-body">
                        <p><strong>Nama Lengkap:</strong> {{ $dataPpdb->nama_lengkap }}</p>
                        <p><strong>TTL:</strong> {{ $dataPpdb->tempat_lahir }}, {{ $dataPpdb->tanggal_lahir }}</p>
                        <p><strong>Jenis Kelamin:</strong> {{ $dataPpdb->jenis_kelamin }}</p>
                        <p><strong>Asal Sekolah:</strong> {{ $dataPpdb->asal_sekolah }}</p>
                        <p><strong>NISN:</strong> {{ $dataPpdb->nisn }}</p>
                        <p><strong>No. Telepon:</strong> {{ $dataPpdb->nomor_telepon }}</p>
                        <p><strong>Alamat:</strong> {{ $dataPpdb->alamat }}</p>
                        <p><strong>Status:</strong>
                            <span class="badge bg-{{ $dataPpdb->status_ppdb == 'diterima' ? 'success' : 'danger' }}">
                                {{ strtoupper($dataPpdb->status_ppdb) }}
                            </span>
                        </p>
                        @if ($dataPpdb->dokumen_rapor)
                            <p><strong>Dokumen Rapor:</strong>
                                <a href="{{ asset('storage/' . $dataPpdb->dokumen_rapor) }}" target="_blank">Lihat
                                    File</a>
                            </p>
                        @endif

                        <a href="{{ route('siswa.dashboard_siswa', $dataPpdb->id) }}" class="btn btn-primary">masuk ke dashbord siswa</a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="text-center p-3" style="background-color: #b2a496;">
        © 2025 <strong>SISMADU</strong> - All rights reserved.
    </div>

    <script>
        function logout() {
            window.location.href = "{{ route('logout') }}"; // Sesuaikan jika perlu
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
