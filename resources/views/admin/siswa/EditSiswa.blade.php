<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h2>Edit Data Siswa</h2>

        <form action="{{ route('admin.siswa.update', $siswa->siswa_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $siswa->alamat) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                    class="form-control">
            </div>

            <input type="date" name="tanggal_lahir" class="form-control"
                value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah tanggal lahir.</small>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="">-- Biarkan Tidak Diubah --</option>
                    <option value="L"
                        {{ old('jenis_kelamin') == 'L' ? 'selected' : ($siswa->jenis_kelamin == 'L' ? 'selected' : '') }}>
                        Laki-laki</option>
                    <option value="P"
                        {{ old('jenis_kelamin') == 'P' ? 'selected' : ($siswa->jenis_kelamin == 'P' ? 'selected' : '') }}>
                        Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $siswa->nomor_telepon) }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Nama Orang Tua</label>
                <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua', $siswa->nama_orang_tua) }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Pekerjaan Orang Tua</label>
                <input type="text" name="pekerjaan_orang_tua"
                    value="{{ old('pekerjaan_orang_tua', $siswa->pekerjaan_orang_tua) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Asal Sekolah</label>
                <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Status PPDB</label>
                <select name="status_ppdb" class="form-control">
                    <option value="menunggu" {{ $siswa->status_ppdb == 'menunggu' ? 'selected' : '' }}>Menunggu
                    </option>
                    <option value="diterima" {{ $siswa->status_ppdb == 'diterima' ? 'selected' : '' }}>Diterima
                    </option>
                    <option value="ditolak" {{ $siswa->status_ppdb == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>
