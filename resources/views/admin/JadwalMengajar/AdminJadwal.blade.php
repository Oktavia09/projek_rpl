<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <title>Document</title>
</head>

<body>
    <div class="container py-4">
        <h3 class="mb-3">📘 Jadwal Mengajar</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
            + Tambah Jadwal
        </button>

        <div class="card">
            <div class="card-header bg-dark text-white">Daftar Jadwal</div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Guru</th>
                            <th>Mapel</th>
                            <th>Kelas</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwal as $j)
                            <tr>
                                <td>{{ $j->guru->user->name ?? $j->guru->nama_lengkap }}</td>
                                <td>{{ $j->mataPelajaran->nama ?? '-' }}</td>
                                <td>
                                    {{ $kelas->firstWhere('id', $j->kelas_id)
                                        ? $kelas->firstWhere('id', $j->kelas_id)->nama .
                                            ' (Tingkat ' .
                                            $kelas->firstWhere('id', $j->kelas_id)->tingkat .
                                            ')'
                                        : '-' }}
                                </td>
                                <td>{{ $j->hari }}</td>
                                <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEditJadwal"
                                        onclick="setEditForm(
                                            {{ $j->id }},
                                            '{{ $j->guru_id }}',
                                            '{{ $j->mapel_id }}',
                                            '{{ $j->kelas_id }}',
                                            '{{ $j->hari }}',
                                            '{{ $j->jam_mulai }}',
                                            '{{ $j->jam_selesai }}'
                                        )">
                                        ✏️ Edit
                                    </button>

                                    <form action="{{ route('admin.jadwal_mengajar.destroy', $j->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Jadwal -->
    <div class="modal fade" id="modalTambahJadwal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.jadwal_mengajar.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Jadwal</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Guru</label>
                                <select name="guru_id" class="form-select" required>
                                    <option selected disabled>-- Pilih Guru --</option>
                                    @foreach ($guru as $g)
                                        <option value="{{ $g->id }}">{{ $g->user->name ?? $g->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Mata Pelajaran</label>
                                <select name="mapel_id" class="form-select" required>
                                    <option selected disabled>-- Pilih Mapel --</option>
                                    @foreach ($mapel as $m)
                                        <option value="{{ $m->id }}">{{ $m->nama }} ({{ $m->kode }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="kelas_id" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Kelas --</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }} (Tingkat
                                            {{ $k->tingkat }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Hari</label>
                                <select name="hari" class="form-select" required>
                                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                                        <option value="{{ $h }}">{{ $h }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Mulai</label>
                                <input type="time" name="jam_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label>Selesai</label>
                                <input type="time" name="jam_selesai" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Simpan</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Jadwal -->
    <div class="modal fade" id="modalEditJadwal" tabindex="-1" aria-labelledby="modalEditJadwalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formEditJadwal" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="modalEditJadwalLabel">
                            <i class="bi bi-pencil-square me-2"></i> Edit Jadwal Mengajar
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Guru -->
                            <div class="col-md-6">
                                <label for="guru_id_edit" class="form-label">👨‍🏫 Guru</label>
                                <select name="guru_id" id="guru_id_edit" class="form-select" required>
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach ($guru as $g)
                                        <option value="{{ $g->id }}">{{ $g->user->name ?? $g->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Mata Pelajaran -->
                            <div class="col-md-6">
                                <label for="mapel_id_edit" class="form-label">📘 Mata Pelajaran</label>
                                <select name="mapel_id" id="mapel_id_edit" class="form-select" required>
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach ($mapel as $m)
                                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kelas -->
                            <div class="col-md-4">
                                <select name="kelas_id" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Kelas --</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }} (Tingkat
                                            {{ $k->tingkat }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Hari -->
                            <div class="col-md-4">
                                <label for="hari_edit" class="form-label">🗓 Hari</label>
                                <select name="hari" id="hari_edit" class="form-select" required>
                                    <option value="">-- Pilih Hari --</option>
                                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                        <option value="{{ $hari }}">{{ $hari }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jam Mulai -->
                            <div class="col-md-2">
                                <label for="jam_mulai_edit" class="form-label">🕘 Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai_edit" class="form-control"
                                    required>
                            </div>

                            <!-- Jam Selesai -->
                            <div class="col-md-2">
                                <label for="jam_selesai_edit" class="form-label">🕙 Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai_edit" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-warning" type="submit">
                            <i class="bi bi-check-circle me-2"></i> Update
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i> Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function setEditForm(id, guru_id, mapel_id, kelas, hari, jam_mulai, jam_selesai) {
            console.log('Setting edit form with:', {
                id,
                guru_id,
                mapel_id,
                kelas,
                hari,
                jam_mulai,
                jam_selesai
            });

            // Set action URL menggunakan route Laravel
            const form = document.getElementById('formEditJadwal');
            form.action = `{{ url('admin/jadwal_mengajar') }}/${id}`;

            // Set nilai form
            document.getElementById('guru_id_edit').value = guru_id;
            document.getElementById('mapel_id_edit').value = mapel_id;
            document.getElementById('kelas_edit').value = kelas;
            document.getElementById('hari_edit').value = hari;
            document.getElementById('jam_mulai_edit').value = jam_mulai;
            document.getElementById('jam_selesai_edit').value = jam_selesai;

            console.log('Form action set to:', form.action);
            console.log('Form method:', form.method);
        }

        // Debug form submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formEditJadwal');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submitting to:', this.action);
                    console.log('Form data:', new FormData(this));

                    // Validasi client-side
                    const requiredFields = ['guru_id', 'mapel_id', 'kelas_id', 'hari', 'jam_mulai',
                        'jam_selesai'
                    ];
                    let isValid = true;

                    requiredFields.forEach(field => {
                        const input = this.querySelector(`[name="${field}"]`);
                        if (!input || !input.value.trim()) {
                            console.error(`Field ${field} is empty`);
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        alert('Semua field harus diisi!');
                        return false;
                    }
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
