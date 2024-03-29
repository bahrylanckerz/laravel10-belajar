<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">Laravel 10</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">L10</a>
        </div>
        <ul class="sidebar-menu">
            <li class="active"><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            @role('Admin')
                <li class=""><a class="nav-link" href="{{ route('users') }}"><i class="fas fa-users"></i><span>Pengguna</span></a></li>
            @endrole
            <li class=""><a class="nav-link" href="{{ route('role') }}"><i class="fas fa-users"></i><span>Role</span></a></li>
            <li class=""><a class="nav-link" href="{{ route('permission') }}"><i class="fas fa-users"></i><span>Permission</span></a></li>
        </ul>
    </aside>
</div>