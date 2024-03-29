<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard | Belajar Laravel 10</title>

    @include('layouts.head')
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <!-- Navbar -->
            @include('layouts.navbar')

            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            @yield('content')

            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </div>

    @include('layouts.script')

    <!-- Custom Scripts -->
    @yield('customJS')
</body>

</html>