<x-Sales.SalesLayouts>

    <head>
        <style>
            .transaksi-container {
                max-width: 900px;
                margin: 0 auto;
            }
            .section-card {
                background: white;
                border-radius: 15px;
                padding: 25px;
                margin-bottom: 25px;
                border: 1px solid #edf2f7;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }
            .section-title {
                font-size: 1.1rem;
                font-weight: 700;
                color: #bc0007;
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                gap: 10px;
                border-bottom: 2px solid #f8f9fa;
                padding-bottom: 10px;
            }
            .form-label {
                font-size: 0.85rem;
                font-weight: 600;
                color: #4a5568;
                margin-bottom: 8px;
                display: block;
            }
            .form-control {
                border-radius: 10px;
                border: 1px solid #e2e8f0;
                padding: 12px 16px;
                font-size: 0.95rem;
                transition: all 0.2s;
                background-color: #f8fafc;
            }
            .form-control:focus {
                background-color: #fff;
                border-color: #bc0007;
                box-shadow: 0 0 0 3px rgba(188, 0, 7, 0.1);
                outline: none;
            }
            .package-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 15px;
            }
            .package-item {
                position: relative;
                cursor: pointer;
            }
            .package-item input {
                position: absolute;
                opacity: 0;
            }
            .package-box {
                border: 2px solid #edf2f7;
                border-radius: 12px;
                padding: 20px;
                transition: all 0.2s;
                height: 100%;
                background: #fff;
            }
            .package-item:hover .package-box {
                border-color: #bc0007;
                transform: translateY(-2px);
            }
            .package-item input:checked + .package-box {
                border-color: #bc0007;
                background-color: #fff8f8;
                box-shadow: 0 10px 15px -3px rgba(188, 0, 7, 0.1);
            }
            .package-name {
                font-weight: 700;
                color: #2d3748;
                margin-bottom: 5px;
                display: block;
            }
            .package-price {
                font-size: 1.1rem;
                font-weight: 800;
                color: #bc0007;
                display: block;
                margin-top: 10px;
            }
            .btn-action {
                padding: 14px 40px;
                border-radius: 12px;
                font-weight: 700;
                transition: all 0.2s;
            }
            .btn-primary-tsel {
                background-color: #bc0007;
                color: white;
                border: none;
                box-shadow: 0 4px 14px rgba(188, 0, 7, 0.3);
            }
            .btn-primary-tsel:hover {
                background-color: #8a0005;
                transform: translateY(-1px);
                box-shadow: 0 6px 20px rgba(188, 0, 7, 0.4);
            }
            .addon-pill {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 20px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 50px;
                cursor: pointer;
                transition: all 0.2s;
            }
            .addon-pill input:checked + span {
                color: #bc0007;
                font-weight: 700;
            }
            .addon-pill:has(input:checked) {
                border-color: #bc0007;
                background: #fff8f8;
            }

            @media (max-width: 768px) {
                .section-card {
                    padding: 15px;
                }
                .btn-action {
                    padding: 12px 20px;
                    width: 100%;
                    font-size: 0.9rem;
                }
                .transaksi-container {
                    padding: 0 10px;
                }
                .section-title {
                    font-size: 1rem;
                }
            }
            .package-item.disabled {
                cursor: not-allowed;
                opacity: 0.5;
            }
            .package-item.disabled .package-box {
                background-color: #f1f5f9;
                border-color: #e2e8f0;
                filter: grayscale(1);
            }
            .highlight .package-box {
                border-color: #edf2f7;
                background-color: #fff;
            }
            /* Styling khusus saat terpilih (checked) */
            .package-item input:checked + .package-box {
                border-color: #bc0007 !important;
                background-color: #fff8f8 !important;
                box-shadow: 0 10px 15px -3px rgba(188, 0, 7, 0.1);
            }
            .payment-icon {
                width: 45px;
                height: 45px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s;
            }
            .package-item:hover .payment-icon {
                transform: scale(1.1);
            }
            .bg-success-subtle {
                background-color: rgba(40, 167, 69, 0.1) !important;
            }
            .bg-primary-subtle {
                background-color: rgba(13, 110, 253, 0.1) !important;
            }
        </style>
    </head>

    <body>
        <div class="transaksi-container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Input Transaksi</h2>
                    <p class="text-muted small mb-0">Lengkapi data di bawah untuk memproses pesanan</p>
                </div>
                <img src="{{ asset('admin_asset/img/photos/logo_telkomsel.png') }}" alt="Logo" style="height: 35px;">
            </div>

            <form action="{{ route('sales/transaksi/submit') }}" method="POST" id="transaksiForm">
                @csrf
                
                {{-- Hidden Fields --}}
                @php $id_transaksi = 'T' . str_pad(Auth::user()->id, 3, '0', STR_PAD_LEFT) . date('dmy') . substr(uniqid(), -4); @endphp
                <input type="hidden" name="id_transaksi" value="{{ $id_transaksi }}">
                <input type="hidden" name="nama_sales" value="{{ Auth::user()->name }}">
                <input type="hidden" name="nomor_telepon" value="{{ Auth::user()->phone }}">
                <input type="hidden" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ date('Y-m-d\TH:i') }}">

                <!-- Section 1: Informasi Pelanggan -->
                <div class="section-card">
                    <div class="section-title">
                        <i class="fas fa-user-circle"></i> Informasi Pelanggan
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Contoh: Budi Santoso" oninput="restrictNameInput(this)" required>
                            <small id="error-message-name" class="text-danger" style="display: none;">Harap masukkan hanya huruf</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor WhatsApp Pelanggan</label>
                            <input type="number" name="telepon_pelanggan" class="form-control" placeholder="0812xxxx" maxlength="13" oninput="validateInjectionNumber(this)" required>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Pilih Paket & Merchandise -->
                <div class="section-card">
                    <div class="section-title">
                        <i class="fas fa-box-open"></i> Pilih Paket Internet
                    </div>
                    <div class="package-grid mb-4">
                        @foreach ($produks as $produk)
                            <label class="package-item">
                                <input type="radio" name="produk" value="{{ $produk->id }}" onchange="filterMerchandises({{ $produk->id }})" required>
                                <div class="package-box">
                                    <span class="package-name">{{ $produk->produk_nama }}</span>
                                    <small class="text-muted d-block">{{ $produk->produk_detail }}</small>
                                    <span class="package-price">Rp {{ number_format($produk->produk_harga_akhir, 0, ',', '.') }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="section-title mt-4 pt-3">
                        <i class="fas fa-gift"></i> Pilih Merchandise
                    </div>
                    <div class="package-grid" id="merchandise-container">
                        @foreach ($merchandises as $merchandise)
                            <label class="package-item radio-item" data-produk-ids="{{ json_encode($merchandise->produk_ids) }}">
                                <input type="radio" name="merchandise" value="{{ $merchandise->id }}" disabled required>
                                <div class="package-box d-flex align-items-center justify-content-center text-center p-3">
                                    <span class="fw-bold small">{{ $merchandise->merch_nama }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Section 3: Metode Pembayaran -->
                <div class="section-card">
                    <div class="section-title">
                        <i class="fas fa-credit-card"></i> Metode Pembayaran
                    </div>
                    <div class="package-grid">
                        <label class="package-item">
                            <input type="radio" name="metode_pembayaran" value="Tunai" required>
                            <div class="package-box d-flex align-items-center gap-3">
                                <div class="payment-icon rounded-circle bg-success-subtle text-success">
                                    <i class="fas fa-money-bill-wave fa-lg"></i>
                                </div>
                                <div>
                                    <span class="package-name mb-0">Tunai</span>
                                    <small class="text-muted">Bayar dengan uang tunai</small>
                                </div>
                            </div>
                        </label>
                        <label class="package-item">
                            <input type="radio" name="metode_pembayaran" value="Nontunai" required>
                            <div class="package-box d-flex align-items-center gap-3">
                                <div class="payment-icon rounded-circle bg-primary-subtle text-primary">
                                    <i class="fas fa-qrcode fa-lg"></i>
                                </div>
                                <div>
                                    <span class="package-name mb-0">Nontunai</span>
                                    <small class="text-muted">QRIS, Transfer, Bank</small>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Section 4: Detail Tambahan -->
                <div class="section-card">
                    <div class="section-title">
                        <i class="fas fa-info-circle"></i> Detail Tambahan
                    </div>
                    <div class="row g-4 align-items-end">
                        <div class="col-md-12 mb-2">
                            <label class="addon-pill">
                                <input type="checkbox" name="addon_perdana" value="1" class="d-none">
                                <i class="fas fa-plus-square text-muted"></i>
                                <span>Tambah Nomor Perdana Baru</span>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor Injeksi (Jika ada)</label>
                            <input type="number" name="nomor_injeksi" class="form-control" placeholder="0812xxxx" maxlength="13">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Aktivasi</label>
                            <input type="date" id="aktivasi-tanggal" name="aktivasi_tanggal" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="button" class="btn btn-light btn-action px-5" onclick="cancelForm()">Batal</button>
                    <button type="submit" class="btn btn-primary-tsel btn-action px-5" onclick="return OkeForm()">Proses Transaksi</button>
                </div>
            </form>
            </form>
        </div>

        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "Berhasil!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonColor: '#bc0007'
                });
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "Gagal!",
                    text: "{{ session('error') }}",
                    icon: "error",
                    confirmButtonColor: '#bc0007'
                });
            });
        </script>
        @endif

    </body>    
</x-Sales.SalesLayouts>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const today = new Date().toISOString().split("T")[0]; // Ambil tanggal hari ini dalam format YYYY-MM-DD
        const dateInput = document.getElementById("aktivasi-tanggal");
        dateInput.setAttribute("min", today); // Set batas minimal tanggal ke hari ini
    });

    function restrictNameInput(input) {
        const errorMessage = document.getElementById('error-message-name');
        const onlyLetters = input.value.replace(/[^a-zA-Z\s]/g, '');
        input.value = onlyLetters;
        errorMessage.style.display = input.value === onlyLetters ? 'none' : 'block';
    }

    function restrictPhoneInput(input) {
        const errorMessage = document.getElementById('error-message-phone');
        const onlyNumbers = input.value.replace(/\D/g, '');
        input.value = onlyNumbers;
        errorMessage.style.display = input.value === onlyNumbers ? 'none' : 'block';
    }

    function validateInjectionNumber(input) {
        const errorMessage = document.getElementById('error-message-injeksi');
        let value = input.value.replace(/\D/g, '');
        if (value.length > 12) {
            value = value.slice(0, 12);
        }
        input.value = value;
        errorMessage.style.display = value.length === 0 ? 'none' : 'block';
    }

    function filterMerchandises(selectedProdukId) {
        const merchandises = document.querySelectorAll('#merchandise-container .radio-item');
        const selectedIdStr = String(selectedProdukId);

        merchandises.forEach(merchandise => {
            const attrValue = merchandise.getAttribute('data-produk-ids');
            let produkIds = [];
            try {
                produkIds = JSON.parse(attrValue) || [];
            } catch (e) {
                produkIds = [];
            }

            const input = merchandise.querySelector('input');
            
            // Periksa apakah produk yang dipilih ada dalam daftar produk_ids milik merchandise ini
            // Jika produk_ids kosong, berarti merchandise ini tersedia untuk SEMUA paket
            const isAllowed = produkIds.length === 0 || produkIds.map(String).includes(selectedIdStr);

            if (isAllowed) {
                input.disabled = false;
                merchandise.classList.remove('disabled');
                merchandise.classList.add('highlight');
                // Berikan efek transisi halus
                merchandise.style.transition = "all 0.3s ease";
            } else {
                input.disabled = true;
                input.checked = false;
                merchandise.classList.add('disabled');
                merchandise.classList.remove('highlight');
            }
        });
    }

    function OkeForm() {
        const inputs = document.querySelectorAll("input[required]");
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderColor = "red";
            } else {
                input.style.borderColor = "";
            }
        });

        const selectedProduk = document.querySelector("input[name='produk']:checked");
        const selectedMerchandise = document.querySelector("input[name='merchandise']:checked");
        const selectedMetode = document.querySelector("input[name='metode_pembayaran']:checked");
        const errorMessage = "Harap lengkapi semua kolom!";

        if (!selectedProduk) {
            Swal.fire({ title: "Peringatan!", text: errorMessage, icon: "warning" });
            return false;
        }

        if (!selectedMerchandise) {
            Swal.fire({ title: "Peringatan!", text: "Harap pilih merchandise yang tersedia!", icon: "warning" });
            return false;
        }

        if (!selectedMetode) {
            Swal.fire({ title: "Peringatan!", text: "Harap pilih metode pembayaran!", icon: "warning" });
            return false;
        }
        if (isValid) {
            // Show loading state
            Swal.fire({
                title: 'Memproses Transaksi...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            return true;
        } else {
            Swal.fire({
                title: "Peringatan!",
                text: "Lengkapi kolom!",
                icon: "warning"
            });
            return false;
        }

    }

    function cancelForm() {
        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah Anda yakin ingin membatalkan pengisian formulir Transaksi?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, batalkan!",
            cancelButtonText: "Tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                // Refresh the page
                window.location.reload();
                
            }
        });
    }

</script>
