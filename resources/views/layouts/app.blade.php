<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #eef1f7, #e3e7f1);
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1e2d7a, #2b3fa0);
            color: white;
            padding-top: 10px;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            width: 40px;
            height: 40px;
            object-fit: contain;
            background: white;
            border-radius: 10px;
            padding: 5px;
        }

        .sidebar-title strong {
            font-size: 0.9rem;
        }

        .sidebar-title small {
            display: block;
            font-size: 0.7rem;
            opacity: 0.6;
        }

        .sidebar-label {
            font-size: 0.7rem;
            padding: 15px 20px 5px;
            opacity: 0.5;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            margin: 5px 12px;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: 0.25s;
        }

        .sidebar a i {
            background: rgba(255, 255, 255, 0.15);
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(4px);
        }

        .active-link {
            background: white;
            color: #2b3fa0 !important;
            font-weight: 600;
        }

        .active-link i {
            background: #2b3fa0;
            color: white;
        }

        /* MAIN */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* HEADER */
        .hero-header {
            height: 80px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .hero-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hero-logo-img {
            width: 35px;
        }

        .hero-welcome {
            font-weight: 600;
            color: #333;
        }

        .hero-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* INFO */
        .info-bar {
            margin: 15px 20px 0;
            padding: 12px 18px;
            background: linear-gradient(135deg, #2b3fa0, #3b52c4);
            color: white;
            border-radius: 12px;
            font-size: 0.85rem;
            display: flex;
            justify-content: space-between;
        }

        /* CONTENT */
        .page-content {
            margin: 20px;
            padding: 25px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .alert {
            border-radius: 10px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .sidebar-title,
            .sidebar-label,
            .sidebar a span {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="d-flex">

        @auth
            <div class="sidebar">
                <div class="sidebar-header">
                    <img src="{{ asset('assets/img/logo.png') }}" class="sidebar-logo">
                    <div class="sidebar-title">
                        <strong>Inventaris</strong>
                        <small>Management</small>
                    </div>
                </div>
                <div class="sidebar-brand">MENU</div>

                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active-link' : '' }}">
                    <i class="fa-solid fa-table-columns"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sidebar-label">Items Data</div>

                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('categories.index') }}"
                        class="{{ request()->routeIs('categories.*') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-bars"></i>
                        <span>Categories</span>
                    </a>
                @endif

                <a href="{{ route('items.index') }}" class="{{ request()->routeIs('items.*') ? 'active-link' : '' }}">
                    <i class="fa-solid fa-box"></i>
                    <span>Items</span>
                </a>

                @if (auth()->user()->role === 'staff')
                    <a href="{{ route('lendings.index') }}" class="{{ request()->routeIs('lendings.*') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-rotate"></i>
                        <span>Lending</span>
                    </a>
                @endif

                <div class="sidebar-label">Accounts</div>

                @if (auth()->user()->role === 'admin')
                    <div class="dropdown">
                        <a class="dropdown-toggle {{ request()->routeIs('users.*') ? 'active-link' : '' }}" href="#"
                            data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user"></i>
                            <span>Users</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('users.index', ['role' => 'admin']) }}">Admin</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.index', ['role' => 'staff']) }}">Staff</a></li>
                        </ul>
                    </div>
                @endif

                @if (auth()->user()->role === 'staff')
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user"></i>
                            <span>User</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('users.edit.self') }}">Edit</a></li>
                        </ul>
                    </div>
                @endif
            </div>
        @endauth

        <div class="main">

            <div class="hero-header">
                <div class="hero-left">
                    <img src="{{ asset('assets/img/logo.png') }}" class="hero-logo-img">
                    <span class="hero-welcome">
                        @auth
                            Welcome Back, {{ auth()->user()->name }}
                        @else
                            Welcome
                        @endauth
                    </span>
                </div>

                @auth
                    <div class="hero-right">
                        <span>{{ now()->format('d F Y') }}</span>

                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endauth
            </div>

            @auth
                <div class="info-bar">
                    <span>Check menu in sidebar</span>
                    <span>{{ auth()->user()->name }}</span>
                </div>
            @endauth

            @if (session('success'))
                <div class="px-3 mt-3">
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="px-3 mt-2">
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="page-content">
                @yield('content')
            </div>

        </div>

    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
