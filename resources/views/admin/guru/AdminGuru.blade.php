<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Guru</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <h4 class="mb-4">Manajemen Data Guru</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Tombol Tambah Guru -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahGuru">
            Tambah Guru
        </button>

        <!-- Tabel Guru -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Mata Pelajaran</th>
                        <th>kelas yang Diampu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($guru as $g)
                        <tr>
                            <td>{{ $g->nama_lengkap }}</td>
                            <td>{{ $g->nip }}</td>
                            <td>{{ $g->no_hp }}</td>
                            <td>{{ $g->user->email ?? '-' }}</td>
                            <td>
                                @foreach ($g->mataPelajaran as $mp)
                                    <span class="badge bg-info text-dark">{{ $mp->nama }}</span>
                                @endforeach
                            </td>

                            <td>
                                @foreach ($g->kelas as $k)
                                    <span class="badge bg-success text-white">{{ $k->nama }}</span>
                                @endforeach
                            </td>

                            <!-- Tombol Edit -->

                            <td>

                                <button type="button" class="btn btn-sm btn-warning mb-1" data-bs-toggle="modal"
                                    data-bs-target="#modalEditGuru{{ $g->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('admin.guru.destroy', $g->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Guru -->
                        <div class="modal fade" id="modalEditGuru{{ $g->id }}" tabindex="-1"
                            aria-labelledby="modalEditGuruLabel{{ $g->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <form action="{{ route('admin.guru.update', $g->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditGuruLabel{{ $g->id }}">Edit
                                                Guru:
                                                {{ $g->nama_lengkap }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label>Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap" class="form-control"
                                                    value="{{ $g->nama_lengkap }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>NIP</label>
                                                <input type="text" name="nip" class="form-control"
                                                    value="{{ $g->nip }}">
                                            </div>

                                            <div class="mb-3">
                                                <label>No HP</label>
                                                <input type="text" name="no_hp" class="form-control"
                                                    value="{{ $g->no_hp }}">
                                            </div>

                                            <div class="mb-3">
                                                <label>Alamat</label>
                                                <textarea name="alamat" class="form-control" rows="2">{{ $g->alamat }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ $g->user->email ?? '' }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>Password (kosongkan jika tidak ingin mengubah)</label>
                                                <input type="password" name="password" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label>Mata Pelajaran</label>
                                                <select name="mapel[]" class="form-select" multiple>
                                                    @foreach ($mapel as $m)
                                                        <option value="{{ $m->id }}"
                                                            {{ $g->mataPelajaran->contains($m->id) ? 'selected' : '' }}>
                                                            {{ $m->nama }} ({{ $m->kelas->nama ?? '-' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label>Kelas yang Diampu</label>
                                                <select name="kelas[]" class="form-select" multiple>
                                                    @foreach ($kelas as $k)
                                                        <option value="{{ $k->id }}"
                                                            {{ $g->kelas->contains($k->id) ? 'selected' : '' }}>
                                                            {{ $k->nama }} (Tingkat {{ $k->tingkat }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
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

    <!-- Modal Tambah Guru -->
    <div class="modal fade" id="modalTambahGuru" tabindex="-1" aria-labelledby="modalTambahGuruLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.guru.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>NIP</label>
                            <input type="text" name="nip" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>No HP</label>
                            <input type="text" name="no_hp" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Mata Pelajaran</label>
                            <select name="mapel[]" class="form-select" multiple>
                                @foreach ($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama }}
                                        ({{ $m->kelas->nama ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Gunakan Ctrl (Windows) / Cmd (Mac) untuk memilih lebih dari
                                satu</small>
                        </div>

                        <div class="mb-3">
                            <label>Kelas yang Diampu</label>
                            <select name="kelas[]" class="form-select" multiple>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }} (Tingkat
                                        {{ $k->tingkat }})</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Gunakan Ctrl (Windows) / Cmd (Mac) untuk memilih lebih dari
                                satu</small>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
