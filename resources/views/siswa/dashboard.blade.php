<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard siswa</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->

    <script src="{{ asset('backend/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/kaiadmin.min.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="index.html" class="logo">
                        <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
                            height="20" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item active">
                            <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Dashboard siswa</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Components</h4>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#base">
                                <i class="fas fa-layer-group"></i>
                                <p>Base</p>
                                <span class="caret"></span>
                            </a>

                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
                                height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav
                            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control" />
                            </div>
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">

                                    <span class="profile-username">

                                        <span class="fw-bold">{{ Auth::user()->name }}</span>
                                        <span class="fw-bold">|||</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="u-text">
                                                    @foreach ($user as $s)
                                                        <h4>{{ $s->nam }}</h4>
                                                        <p class="text-muted">{{ $s->email }}</p>
                                                        <a href="profile.html"
                                                            class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">My Profile</a>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Logout</button>
                                            </form>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Dashboard siswa</h3>

                        </div>
                    </div>


                    {{-- form pengisian siswa --}}

                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h1 class="card-title h3 mb-3">Pendaftaran Siswa Baru</h1>
                                    <p class="text-muted">Silakan lengkapi data diri Anda untuk mendaftar sebagai siswa
                                        baru.</p>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form action="{{ route('siswa.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <!-- Data Pribadi -->
                                        <h5 class="mt-4">Data Pribadi</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nama_lengkap" class="form-label">Nama Lengkap *</label>
                                                <input type="text" name="nama_lengkap" id="nama_lengkap"
                                                    value="{{ old('nama_lengkap') }}" class="form-control" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin *</label>
                                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select"
                                                    required>
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="L"
                                                        {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                                    </option>
                                                    <option value="P"
                                                        {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="tempat_lahir" class="form-label">Tempat Lahir *</label>
                                                <input type="text" name="tempat_lahir" id="tempat_lahir"
                                                    value="{{ old('tempat_lahir') }}" class="form-control" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir *</label>
                                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                                    value="{{ old('tanggal_lahir') }}" class="form-control" required>
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label for="alamat" class="form-label">Alamat Lengkap *</label>
                                                <textarea name="alamat" id="alamat" rows="3" class="form-control" required>{{ old('alamat') }}</textarea>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="nomor_telepon" class="form-label">Nomor Telepon *</label>
                                                <input type="tel" name="nomor_telepon" id="nomor_telepon"
                                                    value="{{ old('nomor_telepon') }}" class="form-control" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="asal_sekolah" class="form-label">Asal Sekolah *</label>
                                                <input type="text" name="asal_sekolah" id="asal_sekolah"
                                                    value="{{ old('asal_sekolah') }}" class="form-control" required>
                                            </div>
                                        </div>

                                        <!-- Data Orang Tua -->
                                        <h5 class="mt-4">Data Orang Tua</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nama_orang_tua" class="form-label">Nama Orang Tua
                                                    *</label>
                                                <input type="text" name="nama_orang_tua" id="nama_orang_tua"
                                                    value="{{ old('nama_orang_tua') }}" class="form-control"
                                                    required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="pekerjaan_orang_tua" class="form-label">Pekerjaan Orang
                                                    Tua *</label>
                                                <input type="text" name="pekerjaan_orang_tua"
                                                    id="pekerjaan_orang_tua" value="{{ old('pekerjaan_orang_tua') }}"
                                                    class="form-control" required>
                                            </div>
                                        </div>

                                        <!-- Upload Dokumen -->
                                        <h5 class="mt-4">Upload Dokumen</h5>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="dokumen_rapor" class="form-label">Dokumen Rapor *</label>
                                                <input type="file" name="dokumen_rapor" id="dokumen_rapor"
                                                    class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                                <div class="form-text">Format: PDF, JPG, PNG (Max: 2MB)</div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="dokumen_akta" class="form-label">Dokumen Akta Kelahiran
                                                    *</label>
                                                <input type="file" name="dokumen_akta" id="dokumen_akta"
                                                    class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                                <div class="form-text">Format: PDF, JPG, PNG (Max: 2MB)</div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="dokumen_foto" class="form-label">Foto Siswa *</label>
                                                <input type="file" name="dokumen_foto" id="dokumen_foto"
                                                    class="form-control" accept=".jpg,.jpeg,.png" required>
                                                <div class="form-text">Format: JPG, PNG (Max: 1MB)</div>
                                            </div>
                                        </div>

                                        <!-- Tombol -->
                                        <div class="d-flex justify-content-between mt-4">
                                            <a href="{{ route('siswa.dashboard') }}"
                                                class="btn btn-secondary">Kembali</a>
                                            <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                                        </div>
                                    </form>

                                    <!-- Modal Berhasil -->
                                    @if (session('success'))
                                        <div class="modal fade" id="successModal" tabindex="-1"
                                            aria-labelledby="successModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-success">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title" id="successModalLabel">Pendaftaran
                                                            Berhasil</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ session('success') }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success"
                                                            data-bs-dismiss="modal">Oke</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Modal Gagal -->
                                    @if (session('error'))
                                        <div class="modal fade" id="errorModal" tabindex="-1"
                                            aria-labelledby="errorModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-danger">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="errorModalLabel">Terjadi Kesalahan
                                                        </h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ session('error') }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid d-flex justify-content-between">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="http://www.themekita.com">
                                    ThemeKita
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Help </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Licenses </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright">
                        2024, made with <i class="fa fa-heart heart text-danger"></i> by
                        <a href="http://www.themekita.com">ThemeKita</a>
                    </div>
                    <div>
                        Distributed by
                        <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
                    </div>
                </div>
            </footer>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('backend/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('backend/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('backend/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('backend/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('backend/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('backend/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    {{-- <script src="{{ asset('backend/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script> --}}

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('backend/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('backend/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('backend/assets/js/kaiadmin.min.js') }}"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="{{ asset('backend/assets/js/setting-demo.js') }}"></script>
    <script src="{{ asset('backend/assets/js/demo.js') }}"></script>

    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            @endif

            @if (session('error'))
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            @endif
        });
    </script>

</body>

</html>
