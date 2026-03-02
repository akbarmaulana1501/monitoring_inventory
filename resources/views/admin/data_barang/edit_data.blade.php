<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ auth()->user()->role }} | Data Barang</title>
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
                        <h1>Edit Data Barang</h1>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-9 col-lg-9">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('update_barang', $barangs->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="kode_barang">Kode Barang</label>
                                            <input type="text" class="form-control" name="kode_barang" id="kode_barang" value="{{$barangs->kode_barang}}" readonly required>
                                        </div>

                                        <div class="form-group">
                                            <label for="nama_barang">Nama Barang</label>
                                            <input type="text" class="form-control" name="nama_barang" value="{{$barangs->nama_barang}}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="kategori">Kategori</label>
                                            <select name="kategori" id="kategori" class="form-control" required>
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach ($kategori as $kat)
                                                <option value="{{ $kat->nama_kategori }}"
                                                    {{ $barangs->kategori == $kat->nama_kategori ? 'selected' : '' }}>
                                                    {{ $kat->nama_kategori }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="stok">Stok Awal</label>
                                            <input type="number" class="form-control" name="stok" value="{{$barangs->stok}}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="satuan">Satuan</label>
                                            <select name="satuan" class="form-control" required>
                                                <option value="" disabled {{ old('satuan', $barangs->satuan) == '' ? 'selected' : '' }}>Pilih Satuan</option>
                                                <option value="unit" {{ old('satuan', $barangs->satuan) == 'unit' ? 'selected' : '' }}>Unit</option>
                                                <option value="pcs" {{ old('satuan', $barangs->satuan) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                                <option value="set" {{ old('satuan', $barangs->satuan) == 'set' ? 'selected' : '' }}>Set</option>
                                                <option value="box" {{ old('satuan', $barangs->satuan) == 'box' ? 'selected' : '' }}>Box</option>
                                                <option value="roll" {{ old('satuan', $barangs->satuan) == 'roll' ? 'selected' : '' }}>Roll</option>
                                                <option value="meter" {{ old('satuan', $barangs->satuan) == 'meter' ? 'selected' : '' }}>Meter</option>
                                                <option value="pack" {{ old('satuan', $barangs->satuan) == 'pack' ? 'selected' : '' }}>Pack</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="lokasi">Lokasi</label>
                                            <select name="lokasi" class="form-control" required>
                                                <option value="" disabled {{ old('lokasi', $barangs->lokasi) == '' ? 'selected' : '' }}>Pilih Lokasi</option>
                                                <option value="GudangA" {{ old('lokasi', $barangs->lokasi) == 'GudangA' ? 'selected' : '' }}>Gudang A</option>
                                                <option value="GudangB" {{ old('lokasi', $barangs->lokasi) == 'GudangB' ? 'selected' : '' }}>Gudang B</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="kondisi">Kondisi</label>
                                            <select name="kondisi" class="form-control">
                                                <option value="Baik" {{ $barangs->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="Rusak" {{ $barangs->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                                <option value="Habis Pakai" {{ $barangs->kondisi == 'Habis Pakai' ? 'selected' : '' }}>Habis Pakai</option>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="/data_barang" class="btn btn-secondary">Kembali</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
            @include('layouts.footer')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#kategori').on('change', function() {
            var kategori = $(this).val();

            if (kategori) {
                $.ajax({
                    url: "{{ route('generate.kode.barang') }}",
                    type: 'GET',
                    data: {
                        kategori: kategori
                    },
                    success: function(response) {
                        $('#kode_barang').val(response.kode);
                    },
                    error: function() {
                        alert('Gagal mengambil kode barang');
                    }
                });
            } else {
                $('#kode_barang').val('');
            }
        });
    </script>

    <!-- General JS Scripts -->
    @include('layouts.script')
</body>

</html>