<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ auth()->user()->role }} | Manajemen Pengguna</title>
    @include('layouts.style')
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Notifications
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                <a href="#" class="dropdown-item dropdown-item-unread">
                                    <div class="dropdown-item-icon bg-primary text-white">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        Template update is available now!
                                        <div class="time text-primary">2 Min Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-icon bg-info text-white">
                                        <i class="far fa-user"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                                        <div class="time">10 Hours Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-icon bg-success text-white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                                        <div class="time">12 Hours Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-icon bg-danger text-white">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        Low disk space. Let's clean it!
                                        <div class="time">17 Hours Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-icon bg-info text-white">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        Welcome to Stisla template!
                                        <div class="time">Yesterday</div>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li> -->
                    @include('layouts.user')
                </ul>
            </nav>
            @include('layouts.logo')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Manajemen Pengguna</h1>
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible show fade" id="success-alert">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            {{ session('success') }}
                        </div>
                    </div>

                    <script>
                        setTimeout(function() {
                            let alert = document.getElementById('success-alert');
                            if (alert) {
                                alert.style.transition = "opacity 0.5s ease";
                                alert.style.opacity = "0";
                                setTimeout(() => alert.remove(), 500);
                            }
                        }, 3000); // 3 detik
                    </script>
                    @endif

                    @if(session('success_nonaktif'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Akun pengguna berhasil dinonaktifkan.',
                            showConfirmButton: true,
                        });
                    </script>
                    @endif

                    @if(session('success_aktif'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Akun pengguna berhasil diaktifkan.',
                            showConfirmButton: true,
                        });
                    </script>
                    @endif

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="/tambah_pengguna" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Username</th>
                                                    <th>role</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user as $index => $u)
                                                <tr>
                                                    <td>{{ $user->firstItem() + $index  }}</td>
                                                    <td>{{ $u->username }}</td>
                                                    <td>{{ $u->role }}</td>
                                                    <td>
                                                        @if($u->status == 'aktif')
                                                        <span class="badge badge-success">Aktif</span>
                                                        @else
                                                        <span class="badge badge-danger">Tidak Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($u->status == 'nonaktif')
                                                        <form id="form-aktif-{{ $u->id }}" action="{{ route('aktifkan_pengguna', $u->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PATCH') <!-- PATCH digunakan untuk update -->
                                                            <button type="button" class="btn btn-success btn-sm" onclick="konfirmasiAktifkan('{{ $u->id }}')">
                                                                <i class="fa fa-power-off"></i>
                                                            </button>
                                                        </form>
                                                        @else
                                                        <form id="form-nonaktif-{{ $u->id }}" action="{{ route('nonaktifkan_pengguna', $u->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif('{{ $u->id }}')">
                                                                <i class="fa fa-power-off"></i>
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer text-right">
                                        <nav class="d-inline-block">
                                            {{ $user->links('pagination::bootstrap-4') }}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
            @include('layouts.footer')
        </div>
    </div>

    <script>
        function konfirmasiNonaktif(id) {
            Swal.fire({
                title: 'Yakin ingin nonaktifkan akun pengguna?',
                text: "Aksi ini tidak bisa dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, nonaktifkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-nonaktif-' + id).submit();
                }
            });
        }
    </script>
    <script>
        function konfirmasiAktifkan(id) {
            Swal.fire({
                title: 'Yakin ingin aktifkan akun pengguna?',
                text: "Aksi ini tidak bisa dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, aktifkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-aktif-' + id).submit();
                }
            });
        }
    </script>

    <!-- General JS Scripts -->
    @include('layouts.script')
</body>

</html>