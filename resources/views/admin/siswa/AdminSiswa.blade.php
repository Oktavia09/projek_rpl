{{-- File: resources/views/admin/AdminSiswa.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Siswa</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="{{ route('admin.siswa.index') }}">
                                <i class="fas fa-users"></i> Data Siswa
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            {{-- Main content --}}
            <div class="container mt-3 col-md-9">
                <h2>Daftar Siswa</h2>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Asal Sekolah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $siswa)
                            <tr>
                                <td>{{ $siswa->nama_lengkap }}</td>
                                <td>{{ $siswa->jenis_kelamin }}</td>
                                <td>{{ $siswa->asal_sekolah }}</td>
                                <td>{{ $siswa->status_ppdb }}</td>
                                <td>
                                    <!-- Button trigger modals -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $siswa->siswa_id }}">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewModal{{ $siswa->siswa_id }}">
                                        Lihat
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $siswa->siswa_id }}">
                                        Hapus
                                    </button>

                                    <!-- Modal Lihat -->
                                    <div class="modal fade" id="viewModal{{ $siswa->siswa_id }}" tabindex="-1"
                                        aria-labelledby="viewModalLabel{{ $siswa->siswa_id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Siswa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Nama:</strong> {{ $siswa->nama_lengkap }}</p>
                                                    <p><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin }}</p>
                                                    <p><strong>Asal Sekolah:</strong> {{ $siswa->asal_sekolah }}</p>
                                                    <p><strong>Status:</strong> {{ $siswa->status_ppdb }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{ $siswa->siswa_id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $siswa->siswa_id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST"
                                                    action="{{ route('admin.siswa.update', $siswa->siswa_id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Siswa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label>Nama Lengkap</label>
                                                            <input type="text" name="nama_lengkap" class="form-control"
                                                                value="{{ $siswa->nama_lengkap }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Jenis Kelamin</label>
                                                            <select name="jenis_kelamin" class="form-control">
                                                                <option value="L"
                                                                    {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                                <option value="P"
                                                                    {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Asal Sekolah</label>
                                                            <input type="text" name="asal_sekolah" class="form-control"
                                                                value="{{ $siswa->asal_sekolah }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Status PPDB</label>
                                                            <select name="status_ppdb" class="form-control">
                                                                <option value="menunggu" {{ $siswa->status_ppdb == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                                <option value="diterima" {{ $siswa->status_ppdb == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                                                <option value="ditolak" {{ $siswa->status_ppdb == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="deleteModal{{ $siswa->siswa_id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $siswa->siswa_id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form
                                                    action="{{ route('admin.siswa.destroy', ['siswa_id' => $siswa->siswa_id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus Siswa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Yakin ingin menghapus <strong>{{ $siswa->nama_lengkap }}</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
