<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Selamat Datang di Program Haji Telkomsel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #f1f5f9, #c3dafe);
            height: 100vh;
            overflow-x: hidden;
        }

        .card {
            border-radius: 16px;
            background-color: #fff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }


        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .staff-carousel-wrapper {
            overflow: hidden;
            width: 850px;
            max-width: 95%;
            margin-top: 2rem;
            position: relative;
        }

        .staff-carousel {
            display: flex;
            gap: 1rem;
            transition: transform 0.6s ease-in-out;
            /* justify-content: center; (menengahkan content)*/
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand img {
            height: 36px;
        }

        .main-content {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
            color: #1e293b;
            animation: fadeIn 1.2s ease-in-out;
            margin-top: 45px;
        }

        .main-content h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .main-content p {
            font-size: 1.1em;
            color: #334155;
            max-width: 1000px;
            margin-bottom: 2rem;
        }

        .main-content a {
            margin-top: -15px;
        }

        .btn-cta {
            background-color: #ec1c24;
            color: white;
            padding: 12px 28px;
            font-size: 1rem;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-cta:hover {
            background-color: #b70f16;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .staff-card {
            background-color: rgba(255, 255, 255, 0.7);
            padding: 0.80rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            animation: fadeIn 1s ease-in-out;
            flex: 0 0 180px;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
            height: 270px;
        }

        .staff-card:hover {
            transform: scale(1.05);
        }

        .staff-card p {
            font-style: italic
        }

        .staff-card img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 0.1rem;
            height: 180px;
            object-fit: cover;
        }

        .staff-card h6 {
            margin: 0;
            padding-top: 15px;
            font-size: 1.1rem;
            color: #0f172a;
        }

        .image-header img {
            width: 100%;
            max-width: 300px;
            height: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }


        /* .quote-section {
            margin-top: 3rem;
            font-size: 1.1rem;
            color: #334155;
            font-style: italic;
            animation: fadeIn 2s ease-in-out;
        } */

        .quote-section {
            margin-top: 3rem;
            font-size: 1rem;
            color: #334155;
            font-style: italic;
            animation: fadeIn 2s ease-in-out;
            font-family: 'Amiri', serif;
            background: rgba(255, 255, 255, 0.7);
            padding: 1.5rem 2rem;
            border-radius: 12px;
            max-width: 950px;
            position: relative;
            border-left: 4px solid #ec1c24;
        }

        .icon-decor {
            font-size: 2rem;
            color: #ec1c24;
            margin: 0 0.5rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 576px) {
            .main-content h1 {
                font-size: 1.8rem;
            }

            .main-content p {
                font-size: 0.95rem;
            }

            .btn-cta {
                font-size: 0.95rem;
                padding: 10px 20px;
            }

            .image-header img {
                max-width: 90%;
            }

            .staff-carousel-wrapper {
                width: 100%;
            }

            .staff-card {
                flex: 0 0 140px;
                height: 240px;
            }

            .staff-card img {
                height: 150px;
            }
        }
    </style>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="{{ url('/programhaji/login') }}">
                    <img src="admin_asset/img/photos/logo_telkomsel.png" alt="Telkomsel Logo" />
                    <span style="font-weight: 700; color: #ec1c24; margin-left: 10px;">PONDOK HAJI</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        {{-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                    </li> --}}
                        {{-- <li class="nav-item">
                        <a class="nav-link" href="#">Tentang</a>
                    </li> --}}
                        <li class="nav-item">
                            {{-- <a class="nav-link" href="{{ url('/programhaji/login') }}" style="font-style: italic">Log
                                In</a> --}}
                            <a class="nav-link btn btn-outline-danger btn-sm" href="{{ url('/programhaji/login') }}"
                                style="border-radius: 20px; font-weight: 500;">
                                <i class="fas fa-sign-in-alt me-1"></i>Log In
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</head>

<body>
    <div id="particles-js"></div>

    <section class="main-content">
        <div class="image-header">
            <img src="{{ asset('admin_asset/img/photos/layer 1.png') }}" alt="Layer 1">
        </div>
        <h1>PONDOK HAJI Telkomsel</h1>
        <p>Selamat datang di sistem layanan pelanggan dan transaksi <strong style="color: #ec1c24;">Program Haji
                Telkomsel</strong><br>
            Untuk <strong>Sales & Kasir</strong> - Semangat Melayani Jamaah Menuju Tanah Suci<br>
            <br> Silakan masuk untuk melanjutkan aktivitas Anda.
        </p>
        <a href="{{ url('/programhaji/login') }}" class="btn-cta">
            <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Aplikasi
        </a>

        <!-- Ikon Haji -->
        <div class="mt-4">
            <i class="fas fa-kaaba icon-decor"></i>
            <i class="fas fa-mosque icon-decor"></i>
            <i class="fas fa-plane-departure icon-decor"></i>
            <i class="fas fa-suitcase-rolling icon-decor"></i>
            <i class="fas fa-hands-helping icon-decor"></i>
        </div>

        <!-- Galeri Karyawan -->
        <div class="staff-carousel-wrapper">
            <div class="staff-carousel" id="staffCarousel">
                <div class="staff-card">
                    <img src="{{ asset('admin_asset/img/photos/VALEN00013.JPG') }}" alt="Aef">
                    <h6>Ferdy Valentino</h6>
                    <p style="font-size: small; font-weight: 200;">Valinfi Team</p>
                </div>
                <div class="staff-card">
                    <img src="{{ asset('admin_asset/img/photos/LILIN10.jpg') }}" alt="Lilin">
                    <h6>Herlina Karolina</h6>
                    <p style="font-size: small; font-weight: 200;">Valinfi Team</p>
                </div>
                <div class="staff-card">
                    <img src="{{ asset('admin_asset/img/photos/firoh12.jpg') }}" alt="Billy">
                    <h6>Dhofiroh Azzah</h6>
                    <p style="font-size: small; font-weight: 200;">Valinfi Team</p>
                </div>
                {{-- <div class="staff-card">
                    <img src="{{ asset('admin_asset/img/photos/VALEN00013.JPG') }}" alt="Firoh">
                    <h6>Ferdy Valentino</h6>
                    <p style="font-size: small; font-weight: 200;">Valinfi Team</p>
                </div>
                <div class="staff-card">
                    <img src="{{ asset('admin_asset/img/photos/Firoh12.jpg') }}" alt="Aef">
                    <h6>Dhofiroh Azzah</h6>
                    <p style="font-size: small; font-weight: 200;">Valinfi Team</p>
                </div>
                <div class="staff-card">
                    <img src="{{ asset('admin_asset/img/photos/LILIN10.jpg') }}" alt="Lilin">
                    <h6>Herlina Karolina</h6>
                    <p style="font-size: small; font-weight: 200;">Valinfi Team</p>
                </div> --}}
                {{-- <div class="staff-card">
                    <img src="{{ asset('admin_asset/img/photos/icon_login.png') }}" alt="Billy">
                    <h6>Billy</h6>
                    <p style="font-size: small; font-weight: 200;">Valinfi Team</p>
                </div> --}}
                {{-- <div class="staff-card">
                    <img src="{{ asset('admin_asset/img/photos/VALEN00013.JPG') }}" alt="Valen">
                    <h6>Ferdy Valentino</h6>
                    <p style="font-size: small; font-weight: 200;">Valinfi Team</p>
                </div> --}}
            </div>

            <!-- Motivasi -->
            <div class="quote-section">
                "Sesungguhnya haji mabrur tiada balasan baginya kecuali surga." - HR. Bukhari Muslim
                {{-- <br>
            🌟 Setiap langkah kecil untuk membantu ibadah, bernilai besar di sisi-Nya. --}}
            </div>

            {{-- <!-- Paket RoaMAX Section -->
            <div class="row">
                <!-- Card 1 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Talkmania Haji</small>
                            <h3 class="fw-bold mb-0">15 Mnt</h3>
                            <small>Berlaku 1 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe"></i> Telepon Haji</span>
                                <span class="fw-bold">15 Mnt</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 50.000
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Internet RoaMAX Saudi Arabia</small>
                            <h3 class="fw-bold mb-0">1 GB</h3>
                            <small>Berlaku 1 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe2"></i> RoaMAX Saudi Arabia</span>
                                <span class="fw-bold">1 GB</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 55.000
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Internet RoaMAX Saudi Arabia</small>
                            <h3 class="fw-bold mb-0">3 GB</h3>
                            <small>Berlaku 3 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe"></i> Total Kuota</span>
                                <span class="fw-bold">3 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe2"></i> RoaMAX Saudi Arabia</span>
                                <span class="fw-bold">2 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-geo-alt"></i> RoaMAX Negara Transit</span>
                                <span class="fw-bold">1 GB</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 110.000
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Card 4 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Talkmania Umroh</small>
                            <h3 class="fw-bold mb-0">100 Mnt</h3>
                            <small>Berlaku 12 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi-phone"></i> Telepon Umroh</span>
                                <span class="fw-bold">100 Mnt</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 250.000
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Internet RoaMAX Umroh</small>
                            <h3 class="fw-bold mb-0">5 GB</h3>
                            <small>Berlaku 12 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe"></i> Total Kuota</span>
                                <span class="fw-bold">5 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe2"></i> RoaMAX Umroh</span>
                                <span class="fw-bold">4 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-geo-alt"></i> RoaMAX Negara Transit</span>
                                <span class="fw-bold">1 GB</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 285.000
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Internet RoaMAX Umrah</small>
                            <h3 class="fw-bold mb-0">10 GB</h3>
                            <small>Berlaku 12 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe"></i> Total Kuota</span>
                                <span class="fw-bold">10 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe2"></i> RoaMAX Umrah</span>
                                <span class="fw-bold">9 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-geo-alt"></i> RoaMAX Negara Transit</span>
                                <span class="fw-bold">1 GB</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 300.000
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Card 7 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Combo RoaMAX Umroh</small>
                            <h3 class="fw-bold mb-0">5 GB</h3>
                            <small>Berlaku 12 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe"></i> Total Kuota</span>
                                <span class="fw-bold">5 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe2"></i> RoaMAX Umroh</span>
                                <span class="fw-bold">4 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-geo-alt"></i> Roaming Negara Transit</span>
                                <span class="fw-bold">1 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi-phone"></i> Nelpon</span>
                                <span class="fw-bold">30 Mnt</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 340.000
                        </div>
                    </div>
                </div>

                <!-- Card 8 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Talkmania Umroh</small>
                            <h3 class="fw-bold mb-0">200 Mnt</h3>
                            <small>Berlaku 17 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi-phone"></i> Telepon Umroh</span>
                                <span class="fw-bold">200 Mnt</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 350.000
                        </div>
                    </div>
                </div>

                <!-- Card 9 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Internet RoaMAX Umroh</small>
                            <h3 class="fw-bold mb-0">10 GB</h3>
                            <small>Berlaku 17 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe"></i> Total Kuota</span>
                                <span class="fw-bold">10 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe2"></i> RoaMAX Umroh</span>
                                <span class="fw-bold">8 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-geo-alt"></i> RoaMAX Negara Transit</span>
                                <span class="fw-bold">2 GB</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 375.000
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Card 10 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Combo RoaMAX Umroh</small>
                            <h3 class="fw-bold mb-0">10 GB</h3>
                            <small>Berlaku 12 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe"></i> Total Kuota</span>
                                <span class="fw-bold">10 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe2"></i> RoaMAX Umroh</span>
                                <span class="fw-bold">9 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-geo-alt"></i> RoaMAX Negara Transit</span>
                                <span class="fw-bold">1 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi-phone"></i> Nelpon</span>
                                <span class="fw-bold">30 Mnt</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 375.000
                        </div>
                    </div>
                </div>

                <!-- Card 11 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Internet RoaMAX Umroh</small>
                            <h3 class="fw-bold mb-0">50 GB</h3>
                            <small>Berlaku 12 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe"></i> Total Kuota</span>
                                <span class="fw-bold">50 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe2"></i> RoaMAX Umroh</span>
                                <span class="fw-bold">49 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-geo-alt"></i> RoaMAX Negara Transit</span>
                                <span class="fw-bold">1 GB</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 400.000
                        </div>
                    </div>
                </div>

                <!-- Card 12 -->
                <div class="col-12 col-sm-6 col-md-4 mt-5">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #e60023, #ff4d4d);">
                            <small class="fw-semibold">Internet RoaMAX Umroh</small>
                            <h3 class="fw-bold mb-0">20 GB</h3>
                            <small>Berlaku 17 hari</small>
                        </div>
                        <div class="p-3" style="background-color: #fafafa;">
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe"></i> Total Kuota</span>
                                <span class="fw-bold">20 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-globe2"></i> RoaMAX Umroh</span>
                                <span class="fw-bold">18 GB</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span><i class="bi bi-geo-alt"></i> RoaMAX Negara Transit</span>
                                <span class="fw-bold">2 GB</span>
                            </div>
                        </div>
                        <div class="text-danger fw-bold text-center py-3 fs-5" style="background-color: #fff;">
                            Rp 425.000
                        </div>
                    </div>
                </div>
            </div>
    </section> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 40
                },
                size: {
                    value: 3
                },
                color: {
                    value: "#94a3b8"
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#94a3b8",
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2
                }
            },
            interactivity: {
                events: {
                    onhover: {
                        enable: true,
                        mode: "repulse"
                    },
                    onclick: {
                        enable: true,
                        mode: "push"
                    }
                },
                modes: {
                    repulse: {
                        distance: 100
                    },
                    push: {
                        particles_nb: 4
                    }
                }
            }
        });
    </script>

    <script>
        // STAFF SLIDER
        const staffCarousel = document.getElementById("staffCarousel");
        let staffCards = Array.from(staffCarousel.children);
        const visibleCards = 4;

        // Duplicate elements for seamless looping
        staffCards.forEach(card => {
            const clone = card.cloneNode(true);
            staffCarousel.appendChild(clone);
        });

        let offset = 0;
        const cardWidth = staffCards[0].offsetWidth + 16; // card width + gap

        function slideCarousel() {
            offset += 1;

            if (offset >= (staffCards.length + 1) * cardWidth) {
                offset = 0;
            }

            staffCarousel.style.transform = `translateX(-${offset}px)`;
            requestAnimationFrame(slideCarousel);
        }

        // Start animation
        requestAnimationFrame(slideCarousel);
    </script>

</body>

</html>
