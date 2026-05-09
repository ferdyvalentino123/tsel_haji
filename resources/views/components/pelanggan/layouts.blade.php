<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pelanggan - Telkomsel RoaMAX Haji</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
            min-height: 100vh;
        }

        /* Navbar Styling */
        .navbar-custom {
            background: linear-gradient(135deg, #bc0007 0%, #e2241d 100%);
            box-shadow: 0 4px 15px rgba(188, 0, 7, 0.2);
            padding: 1rem 0;
        }

        .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand img {
            height: 40px;
            filter: brightness(0) invert(1);
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 10px;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff !important;
        }

        .user-info {
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .btn-logout {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #fff;
            color: #bc0007;
            border-color: #fff;
        }

        /* Main Content */
        .main-content {
            padding: 30px 0;
            min-height: calc(100vh - 180px);
        }

        /* Footer */
        .footer-custom {
            background: linear-gradient(135deg, #bc0007 0%, #8a0005 100%);
            color: #fff;
            padding: 60px 0 20px;
            margin-top: 60px;
            border-top: 8px solid rgba(0,0,0,0.1);
        }

        .footer-custom h5 {
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .footer-custom p,
        .footer-custom a,
        .footer-custom li {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.95rem;
        }

        .footer-custom a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .social-icons a {
            display: inline-flex;
            width: 45px;
            height: 45px;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: #fff;
            color: #bc0007;
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin-top: 40px;
            padding-top: 25px;
            text-align: center;
            font-size: 0.85rem;
            opacity: 0.8;
        }


        /* Responsive Dropdown Mobile */
        @media (max-width: 991px) {
            .navbar-brand {
                font-size: 1.25rem;
            }

            .navbar-collapse {
                position: absolute;
                top: 110%; /* tepat di bawah navbar */
                right: 15px;
                background-color: #ffffff;
                width: 240px;
                border-radius: 16px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                padding: 15px;
                z-index: 1050;
            }

            .navbar-nav {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .navbar-nav .nav-item {
                margin: 0;
                width: 100%;
            }

            /* Beranda & Riwayat full width */
            .navbar-nav .nav-item:nth-child(1),
            .navbar-nav .nav-item:nth-child(2) {
                grid-column: span 2;
            }

            .navbar-nav .nav-item.ms-2 {
                margin-left: 0 !important;
            }

            .navbar-nav .nav-link {
                color: #1a1c1c !important;
                padding: 12px 15px;
                margin: 0;
                border-radius: 10px;
                display: flex;
                align-items: center;
                gap: 12px;
                height: 100%;
            }

            /* Center avatar cell */
            .navbar-nav .nav-item:nth-child(3) .nav-link {
                justify-content: center;
                background-color: rgba(188, 0, 7, 0.03); 
            }

            .navbar-nav .nav-link:hover,
            .navbar-nav .nav-link.active {
                background-color: rgba(188, 0, 7, 0.08);
                color: #bc0007 !important;
            }

            .user-avatar {
                background-color: rgba(188, 0, 7, 0.1);
                color: #bc0007;
                margin: 0 auto;
            }

            .navbar-nav form.d-inline {
                height: 100%;
                display: block;
            }

            .btn-logout {
                background-color: #f9f9f9;
                color: #1a1c1c;
                border: 1px solid #e2e2e2;
                width: 100%;
                height: 100%;
                justify-content: center;
                padding: 12px 15px;
                display: flex;
                align-items: center;
                gap: 8px;
                border-radius: 10px;
            }

            .btn-logout:hover {
                background-color: #ffebee;
                color: #bc0007;
                border-color: #ffcdd2;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('pelanggan.home') }}">
                <i class="fas fa-mosque"></i>
                Telkomsel RoaMAX Haji
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    style="border-color: rgba(255,255,255,0.5);">
                <span class="navbar-toggler-icon" style="filter: brightness(0) invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pelanggan.home') ? 'active' : '' }}" 
                           href="{{ route('pelanggan.home') }}">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pelanggan.riwayat-transaksi') ? 'active' : '' }}" 
                           href="{{ route('pelanggan.riwayat-transaksi') }}">
                            <i class="fas fa-history"></i> Riwayat Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pelanggan.profil') ? 'active' : '' }}" 
                           href="{{ route('pelanggan.profil') }}" style="cursor: pointer;">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            {{-- <span class="d-none d-md-inline ms-2">{{ Auth::user()->name }}</span> --}}
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-logout">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Alert Messages -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Page Content -->
            {{ $slot }}
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0 text-center text-md-start pe-lg-4">
                    <h5 class="fw-bold mb-4">
                        <img src="{{ asset('admin_asset/img/photos/logo_telkomsel.png') }}" onerror="this.style.display='none'" style="height:28px; filter:brightness(0) invert(1); margin-right:8px; vertical-align:middle;" alt="Logo"/> 
                        RoaMAX Haji
                    </h5>
                    <p style="line-height:1.7; opacity:0.85;">Solusi roaming terbaik untuk konektivitas Anda di tanah suci. Paket kuota internet khusus ibadah haji yang andal, kuat, dan terpercaya tanpa perlu ganti kartu.</p>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-5 mb-lg-0 text-center text-md-start">
                    <h5 class="fw-bold mb-4">Pusat Bantuan</h5>
                    <ul class="list-unstyled" style="line-height:2.4; opacity:0.85;">
                        <li><i class="fas fa-phone-alt me-2" style="width: 20px;"></i> Call Center: <strong>188</strong></li>
                        <li><i class="fas fa-envelope me-2" style="width: 20px;"></i> cs@telkomsel.co.id</li>
                        <li><i class="fas fa-clock me-2" style="width: 20px;"></i> Beroperasi 24 Jam Penuh</li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 mb-5 mb-lg-0 text-center text-md-start">
                    <h5 class="fw-bold mb-4">Navigasi</h5>
                    <ul class="list-unstyled" style="line-height:2.4; opacity:0.85;">
                        <li><a href="{{ route('pelanggan.home') }}" class="text-white text-decoration-none hover-underline"><i class="fas fa-angle-right me-1"></i> Beli Paket</a></li>
                        <li><a href="{{ route('pelanggan.riwayat-transaksi') }}" class="text-white text-decoration-none hover-underline"><i class="fas fa-angle-right me-1"></i> Riwayat Anda</a></li>
                        <li><a href="{{ route('pelanggan.profil') }}" class="text-white text-decoration-none hover-underline"><i class="fas fa-angle-right me-1"></i> Profil Akun</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 text-center text-md-start">
                    <h5 class="fw-bold mb-4">Hubungi Kami</h5>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p class="m-0">&copy; 2026 Telkomsel RoaMAX Haji. 
                    <br>Hak Cipta Dilindungi Undang-Undang.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>






