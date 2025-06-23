<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SISMADU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            font-size: 14px;
        }

        .navbar {
            background-color: #b2a496;
        }

        .dropdown-menu {
            background-color: #f1f1f1;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #886e58;
            color: #f1f1f1;
        }

        body {
            background-color: #f1f1f1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            flex: 1;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        h3 {
            color: #b2a496;
        }

        .form-container {
            max-width: 950px;
            margin: auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            color: #000;
        }

        .form-control,
        textarea {
            background-color: #f8f9fa;
            color: #000;
        }

        .input-submit {
            width: 100%;
            padding: 12px;
            background-color: #b2a496;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .input-submit:hover {
            background-color: #886e58;
        }

        .navbar {
            background-color: #b2a496;
        }

        .navbar-nav .nav-item {
            position: relative;
        }

        .navbar-nav .nav-link {
            color: white;
            display: block;
        }

        .navbar-nav .nav-link:hover {
            background-color: #886e58;
            color: white;
        }

        table tr td {
            padding: 8px 5px;
        }

        .card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background-color: #f4f4f4;
            border-bottom: 1px solid #ddd;
        }

        .card-body {
            padding: 0.75rem 1.25rem;
        }

        h5 {
            font-size: 1rem;
            color: #4d3f33;
        }

        .list-group-item {
            font-size: 0.9rem;
            background-color: #fff;
            border: none;
            border-bottom: 1px solid #eee;
            padding: 0.5rem 0.75rem;
        }

        .btn-outline-secondary {
            font-size: 0.8rem;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .accordion-item {
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .accordion-button {
            background-color: #e9f2ff;
            color: #0a0a0a;
            font-weight: 600;
            border-radius: 6px 6px 0 0;
        }

        .accordion-button.collapsed {
            background-color: #ffffff;
        }

        .accordion-body ul {
            margin: 0;
            padding-left: 1.2rem;
        }

        .accordion-body li {
            margin-bottom: 6px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold ms-4" href="#">SISMADU</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white ms-2" href="{{ route('guru.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white ms-2" href="{{ route('guru.jadwal_ajar.index') }}">Jadwal Mengajar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white ms-2" href="">Unggah Materi & Tugas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white ms-2" href="#">Nilai Siswa</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper py-5">
        <h3 class="text-center fw-bold mb-4">JADWAL MENGAJAR SEMUA GURU</h3>
        <div class="container">
            <div class="card shadow-sm rounded p-4 bg-white">
                <div class="accordion" id="accordionJadwal">
                    @php $counter = 0; @endphp
                    @foreach ($jadwal->groupBy('guru.nama_lengkap') as $namaGuru => $jadwalGuru)
                        @php
                            $isGuruLogin = $guruLogin && $jadwalGuru->first()->guru->id === $guruLogin->id;
                        @endphp

                        <div class="accordion-item mb-2">
                            <h2 class="accordion-header" id="heading{{ $counter }}">
                                <button
                                    class="accordion-button {{ $counter != 0 ? 'collapsed' : '' }} {{ $isGuruLogin ? 'bg-info text-white' : '' }}"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $counter }}"
                                    aria-expanded="{{ $counter == 0 ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $counter }}">
                                    {{ $namaGuru }} - {{ $jadwalGuru->first()->mataPelajaran->nama ?? '-' }}
                                    @if ($isGuruLogin)
                                        <span class="badge bg-white text-info ms-2">Anda</span>
                                    @endif
                                </button>
                            </h2>
                            <div id="collapse{{ $counter }}"
                                class="accordion-collapse collapse {{ $counter == 0 ? 'show' : '' }}"
                                aria-labelledby="heading{{ $counter }}" data-bs-parent="#accordionJadwal">
                                <div class="accordion-body">
                                    <ul class="mb-0">
                                        @foreach ($jadwalGuru->sortBy('hari') as $item)
                                            <li>
                                                {{ ucfirst($item->hari) }},
                                                {{ $item->jam_mulai }} - {{ $item->jam_selesai }}
                                                (Kelas {{ $item->kelas }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @php $counter++; @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>






    <!-- Footer -->
    <div class="text-center p-3" style="background-color: #b2a496">
        © 2025 <strong>SISMADU</strong> - All rights reserved.
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
</body>

</html>
