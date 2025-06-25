<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Mingguan - SISMADU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #ff9800;  /* Warna utama orange */
            --primary-dark: #e65100;   /* Warna orange lebih gelap */
            --primary-light: #ffb74d;  /* Warna orange lebih terang */
            --secondary-color: #f5f5f5;
            --accent-color: #2196f3;    /* Warna aksen biru */
            --hover-color: #ffa726;     /* Warna hover orange */
            --text-color: #333;
            --text-light: #777;
        }

        body {
            background-color: #fafafa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: white !important;
        }

        .nav-link {
            color: white !important;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .nav-link:hover {
            color: #fff3e0 !important;
            transform: translateY(-1px);
        }

        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            border-top: 4px solid var(--primary-color);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(255, 152, 0, 0.15);
        }

        .card-header {
            background-color: white;
            color: var(--primary-color);
            padding: 1.2rem;
            border-bottom: 1px solid rgba(255, 152, 0, 0.2);
        }

        .card-title {
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: var(--primary-color);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            text-transform: capitalize;
            vertical-align: middle;
            padding: 12px 8px;
            border: none;
        }

        .table td {
            vertical-align: middle;
            padding: 12px 8px;
            border: 1px solid #f0f0f0;
        }

        .time-column {
            background-color: #fff8e1;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .badge-kelas {
            background-color: var(--accent-color);
            color: white;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .schedule-cell {
            min-height: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
            padding: 8px;
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        .schedule-cell:hover {
            background-color: #fff3e0;
        }

        .schedule-cell.empty {
            color: #bdbdbd;
            font-style: italic;
        }

        .schedule-item {
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .schedule-item:last-child {
            margin-bottom: 0;
        }

        .subject-name {
            font-weight: 600;
            color: var(--primary-dark);
        }

        .teacher-name {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        /* Warna khusus untuk row */
        .table-row-highlight {
            background-color: #fff3e0;
        }

        .table-row-highlight:hover {
            background-color: #ffe0b2;
        }

        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem 0;
            margin-top: 3rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.85rem;
            }

            .card-header {
                padding: 1rem;
            }

            .card-title {
                font-size: 1.1rem;
            }

            .table th,
            .table td {
                padding: 8px 4px;
            }

            .schedule-cell {
                min-height: 60px;
                padding: 4px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-body {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span>SISMADU</span>
            </a>
            <div class="d-flex">
                <div class="nav-item nav-link" onclick="logout()" style="cursor: pointer;">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Jadwal Mingguan -->
    @php
        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

        $jamList = $jadwal
            ->map(function ($j) {
                return [
                    'mulai' => $j->jam_mulai,
                    'selesai' => $j->jam_selesai,
                    'label' => $j->jam_mulai . ' - ' . $j->jam_selesai,
                ];
            })
            ->unique('label')
            ->sortBy('mulai')
            ->values();
    @endphp

    <div class="container py-4">
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold text-center" style="color: var(--primary-color);">Jadwal Pelajaran</h2>
                <p class="text-center" style="color: var(--text-light);">Jadwal mingguan mata pelajaran</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-calendar-week"></i>
                    Jadwal Mingguan
                </h3>
            </div>
            <div class="card-body">
                @if ($jadwal->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x" style="font-size: 3rem; color: #bdbdbd;"></i>
                        <p class="text-muted mt-3">Belum ada jadwal tersedia</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 120px;">Waktu</th>
                                    @foreach ($hariList as $hari)
                                        <th>{{ ucfirst($hari) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jamList as $index => $jam)
                                    <tr class="{{ $index % 2 === 0 ? 'table-row-highlight' : '' }}">
                                        <td class="time-column">{{ $jam['label'] }}</td>
                                        @foreach ($hariList as $hari)
                                            @php
                                                $item = $jadwal->first(
                                                    fn($j) => strtolower($j->hari) === $hari &&
                                                        $j->jam_mulai === $jam['mulai'] &&
                                                        $j->jam_selesai === $jam['selesai'],
                                                );
                                            @endphp
                                            <td>
                                                <div class="schedule-cell {{ !$item ? 'empty' : '' }}">
                                                    @if ($item)
                                                        <div class="schedule-item subject-name">
                                                            {{ $item->mataPelajaran->nama ?? 'Mata Pelajaran' }}
                                                        </div>
                                                        <div class="schedule-item teacher-name">
                                                            <i class="bi bi-person-fill"></i>
                                                            {{ $item->guru->nama_lengkap ?? 'Guru' }}
                                                        </div>
                                                        <div class="schedule-item">
                                                            <span class="badge-kelas">
                                                                <i class="bi bi-people-fill"></i>
                                                                {{ $item->kelas->nama ?? 'Kelas' }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class="text-center">-</div>
                                                    @endif
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    SISMADU
                </div>
                <div class="footer-copyright">
                    © 2025 Sistem Informasi Sekolah Madu
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function logout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                window.location.href = "{{ route('logout') }}";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
