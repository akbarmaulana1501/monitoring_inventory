<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mb-3">
            <img src="{{asset('template/assets/img/logo.png')}}" alt="?" style="width: 30%;">
            @php
                $role = Auth::user()->role;
                $dashboardUrl = '#'; // default
                if ($role == 'admin') {
                    $dashboardUrl = '/index_admin';
                } elseif ($role == 'petugas') {
                    $dashboardUrl = '/index_petugas';
                } elseif ($role == 'pimpinan') {
                    $dashboardUrl = '/index_pimpinan';
                }
            @endphp
            <a href="{{ $dashboardUrl }}">SmartStock</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <img src="{{asset('template/assets/img/logo.png')}}" alt="?" style="width: 40%;">
        </div>
        <ul class="sidebar-menu">
            @include('layouts.sidebar')
        </ul>
    </aside>
</div>