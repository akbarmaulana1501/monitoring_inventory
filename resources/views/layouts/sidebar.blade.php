@php
$userRole = auth()->user()->role;
@endphp
@if($userRole == 'admin')
<li class="{{ request()->is('data_barang') ? 'active' : '' }}">
    <a class="nav-link" href="/data_barang"><i class="fas fa-columns"></i> <span>Data Barang</span></a>
</li>

<li class="{{ request()->is('stok_masuk') ? 'active' : '' }}">
    <a class="nav-link" href="/stok_masuk"><i class="fas fa-sign-in-alt"></i> <span>Stok Masuk</span></a>
</li>

<li class="{{ request()->is('stok_keluar') ? 'active' : '' }}">
    <a class="nav-link" href="/stok_keluar"><i class="fas fa-sign-out-alt"></i> <span>Stok Keluar</span></a>
</li>

<!-- <li class="{{ request()->is('transaksi') ? 'active' : '' }}">
    <a class="nav-link" href="/transaksi"><i class="fas fa-file"></i> <span>Transaksi</span></a>
</li> -->

<li class="{{ request()->is('kategori') ? 'active' : '' }}">
    <a class="nav-link" href="/kategori"><i class="fas fa-columns"></i> <span>Kategori</span></a>
</li>

<li class="{{ request()->is('manajemen_pengguna') ? 'active' : '' }}">
    <a class="nav-link" href="/manajemen_pengguna"><i class="fas fa-users"></i> <span>Manajemen Pengguna</span></a>
</li>

<li class="{{ request()->is('laporan') ? 'active' : '' }}">
    <a class="nav-link" href="/laporan"><i class="fas fa-flag"></i> <span>Laporan</span></a>
</li>

@endif

@if($userRole == 'petugas')
<li class="{{ request()->is('data_barang_petugas') ? 'active' : '' }}">
    <a class="nav-link" href="/data_barang_petugas"><i class="fas fa-columns"></i> <span>Data Barang</span></a>
</li>
<li class="{{ request()->is('stok_masuk_petugas') ? 'active' : '' }}">
    <a class="nav-link" href="/stok_masuk_petugas"><i class="fas fa-sign-in-alt"></i> <span>Stok Masuk</span></a>
</li>
<li class="{{ request()->is('stok_keluar_petugas') ? 'active' : '' }}">
    <a class="nav-link" href="/stok_keluar_petugas"><i class="fas fa-sign-out-alt"></i> <span>Stok Keluar</span></a>
</li>
@endif

@if($userRole == 'pimpinan')
<li class="{{ request()->is('data_barang_pimpinan') ? 'active' : '' }}">
    <a class="nav-link" href="/data_barang_pimpinan"><i class="fas fa-columns"></i> <span>Data Barang</span></a>
</li>
<li class="{{ request()->is('stok_masuk_pimpinan') ? 'active' : '' }}">
    <a class="nav-link" href="/stok_masuk_pimpinan"><i class="fas fa-sign-in-alt"></i> <span>Stok Masuk</span></a>
</li>
<li class="{{ request()->is('stok_keluar_pimpinan') ? 'active' : '' }}">
    <a class="nav-link" href="/stok_keluar_pimpinan"><i class="fas fa-sign-out-alt"></i> <span>Stok Keluar</span></a>
</li>
<li class="{{ request()->is('laporan_pimpinan') ? 'active' : '' }}">
    <a class="nav-link" href="/laporan_pimpinan"><i class="fas fa-flag"></i> <span>Laporan</span></a>
</li>
@endif