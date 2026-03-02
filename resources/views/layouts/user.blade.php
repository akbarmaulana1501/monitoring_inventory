@auth
@php
$role = auth()->user()->role;

if ($role == 'admin') {
$avatar = 'avatar-1.png';
} elseif ($role == 'petugas') {
$avatar = 'avatar-2.png';
} elseif ($role == 'pimpinan') {
$avatar = 'avatar-3.png';
} else {
$avatar = 'avatar-default.png';
}
@endphp

<li class="dropdown">
    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{ asset('template/assets/img/avatar/' . $avatar) }}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->username }}</div>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="{{ route('profil') }}" class="dropdown-item has-icon">
            <i class="fas fa-user"></i> Profile Saya
        </a>
        <div class="dropdown-divider"></div>

        <a href="#" class="dropdown-item text-danger"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>

        <form id="logout-form" action="/logout" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</li>
@endauth