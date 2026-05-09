<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Dashboard Admin - Telkomsel Haji">
    <meta name="author" content="Telkomsel">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <title>@yield('title', 'Admin Dashboard') - Telkomsel Haji</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #bc0007;
            /* Telkomsel Red */
            --primary-dark: #8a0005;
            --primary-light: #e62020;
            --sidebar-bg: #bc0007;
            --sidebar-hover: rgba(255, 255, 255, 0.1);
            --bg-light: #f5f7f9;
            --text-main: #333;
            --text-muted: #888;
            --border-color: #eaeaea;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            font-size: 13.5px;
            /* Sedikit diperkecil dari default */
            background-color: var(--bg-light);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* Flex Layout Container */
        .wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* SIDEBAR STYLES */
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background: linear-gradient(160deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            transition: margin-left 0.35s ease-in-out;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .sidebar.collapsed {
            margin-left: -250px;
        }

        .sidebar-header-brand {
            padding: 1.5rem 1.25rem;
            font-size: 1.15rem;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            justify-content: center;
            text-align: center;
        }

        .sidebar-header-brand:hover {
            color: #ffdce0;
        }

        .sidebar-header-brand img {
            height: 48px;
            margin-right: 0;
            margin-bottom: 10px;
            filter: brightness(0) invert(1);
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav-header {
            padding: 1.5rem 1.5rem 0.5rem;
            font-size: 0.70rem;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: 1px;
        }

        .sidebar-item {
            margin-bottom: 0.2rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.75rem;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .sidebar-link i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 10px;
            text-align: center;
        }

        .sidebar-link:hover {
            background-color: var(--sidebar-hover);
            color: #fff;
            border-left-color: rgba(255, 255, 255, 0.3);
        }

        .sidebar-item.active .sidebar-link {
            background-color: rgba(0, 0, 0, 0.15);
            color: #fff;
            border-left-color: #fff;
            font-weight: 600;
        }

        /* MAIN CONTENT STYLES */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            /* Important for flex children to allow text truncation/shrinking */
            background-color: var(--bg-light);
            height: 100vh;
            overflow-y: auto;
            transition: all 0.35s ease-in-out;
        }

        /* TOP NAVBAR */
        .top-navbar {
            background: #fff;
            height: 65px;
            min-height: 65px;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
            z-index: 10;
        }

        .hamburger-btn {
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .hamburger-btn:hover {
            background: #f0f0f0;
            color: var(--primary);
        }

        .nav-user {
            color: var(--text-main);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 20px;
            transition: background 0.2s;
        }

        .nav-user:hover {
            background: #f0f0f0;
        }

        /* DASHBOARD WIDGETS & CARDS */
        .content-area {
            padding: 2rem 1.5rem;
        }

        .page-title {
            font-size: 1.45rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #222;
        }

        /* Stats Cards */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            border-color: #ffdce0;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: rgba(188, 0, 7, 0.08);
            /* Light Red */
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .stat-info {
            flex: 1;
            min-width: 0;
            /* Ensures child text can truncate/wrap */
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .stat-value {
            font-size: 1.35rem;
            /* Fallback */
            font-size: clamp(1rem, 2vw, 1.35rem);
            /* Responsive font-size */
            font-weight: 800;
            color: #111;
            word-break: break-word;
            /* Allows breaking lines if the amount gets too big */
            line-height: 1.2;
        }

        /* Tables & Content Cards */
        .content-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--border-color);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .content-card .card-header {
            background: #fff;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-card .card-header h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: #222;
        }

        .table-custom {
            width: 100%;
            margin-bottom: 0;
        }

        .table-custom th {
            background-color: #fafbfc;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 1rem 1.5rem;
        }

        .table-custom td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
            padding: 0.4rem 1rem;
            border-radius: 6px;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Responsive toggles */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                height: 100%;
                top: 0;
                left: 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="wrapper">

        <!-- SIDEBAR -->
        <nav id="sidebar" class="sidebar">
            <a class="sidebar-header-brand" href="{{ route('admin.home') }}">
                <img src="{{ asset('admin_asset/img/photos/logo_telkomsel.png') }}"
                    onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/b/bc/Telkomsel_2021_icon.svg'"
                    alt="Telkomsel" />
                <div>
                    <span style="font-size: 1rem;">PONDOK HAJI</span><br>
                    <span style="font-size: 0.75rem; font-weight:400; opacity:0.8;">Admin Panel</span>
                </div>
            </a>

            <div class="sidebar-content">
                <ul class="sidebar-nav">
                    <li class="sidebar-nav-header">Menu Utama</li>
                    <li class="sidebar-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.home') }}">
                            <i class="fas fa-chart-pie"></i> Dashboard
                        </a>
                    </li>

                    <li class="sidebar-nav-header">Kelola Data</li>
                    <li class="sidebar-item {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.produk.index') }}">
                            <i class="fas fa-box"></i> Produk
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.merchandise.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.merchandise.index') }}">
                            <i class="fas fa-gift"></i> Merchandise
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.stock-history.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.stock-history.index') }}">
                            <i class="fas fa-history"></i> Pantau Stok
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.transaksi.index') }}">
                            <i class="fas fa-credit-card"></i> Transaksi
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.monitor.setoran') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.monitor.setoran') }}">
                            <i class="fas fa-money-bill-wave"></i> Setoran Sales
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.monitor.void') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.monitor.void') }}">
                            <i class="fas fa-trash-alt"></i> Monitor Void
                        </a>
                    </li>
                    {{-- <li class="sidebar-item {{ request()->routeIs('admin.insentif.summary') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.insentif.summary') }}">
                            <i class="fas fa-money-bill-trend-up"></i> Rekapan Insentif
                        </a>
                    </li> --}}

                    <li class="sidebar-nav-header">Manajemen</li>
                    <li class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i> Pengguna
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- MAIN CONTENT WRAPPER -->
        <div class="main">

            <!-- TOP NAVBAR -->
            <nav class="top-navbar">
                <div>
                    <button id="sidebarToggle" class="hamburger-btn">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <div class="dropdown">
                    <a href="#" class="nav-user dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle fa-lg text-secondary"></i>
                        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                        <li><a class="dropdown-item py-2" href="{{ route('admin.users.edit', Auth::user()->id) }}"><i
                                    class="fas fa-user me-2 text-muted"></i> Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- PAGE CONTENT -->
            <main class="content-area">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("sidebarToggle");

            // Toggle Sidebar based on flex margin
            toggleBtn.addEventListener("click", function(e) {
                e.preventDefault();
                sidebar.classList.toggle("collapsed");
            });

            // Handle responsive behavior (Auto collapse on mobile)
            if (window.innerWidth < 768) {
                sidebar.classList.add("collapsed");
            }

            window.addEventListener("resize", function() {
                if (window.innerWidth < 768) {
                    sidebar.classList.add("collapsed");
                } else {
                    sidebar.classList.remove("collapsed");
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
