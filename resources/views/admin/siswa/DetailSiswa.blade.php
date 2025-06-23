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
        <form action="{{ route('admin.siswa.update', ['siswa_id' => $siswa->siswa_id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                    value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}">
            </div>

            {{-- Tambahkan field lainnya sesuai kebutuhan seperti alamat, tanggal lahir, dsb --}}

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>
