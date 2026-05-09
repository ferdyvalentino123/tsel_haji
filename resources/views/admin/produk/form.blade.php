@extends("admin.layout")
@section("title", isset($produk) ? "Edit Produk" : "Tambah Produk")
@section("content")

<style>
    .form-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease-out;
    }

    .form-header {
        background: linear-gradient(135deg, #ec1c24 0%, #b31217 100%);
        padding: 30px 40px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 10%, transparent 40%);
        background-size: 30% 30%;
        animation: pulsePattern 15s linear infinite;
        opacity: 0.8;
        pointer-events: none;
    }

    @keyframes pulsePattern {
        0% { transform: rotate(0deg) translate(-5%, -5%); }
        50% { transform: rotate(180deg) translate(5%, 5%); }
        100% { transform: rotate(360deg) translate(-5%, -5%); }
    }

    .form-header h5 {
        margin: 0;
        font-weight: 800;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 1;
    }

    .form-body {
        padding: 40px;
        background-color: #fafbfc;
    }

    .custom-form-label {
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.95rem;
        letter-spacing: 0.3px;
    }

    .custom-form-label i {
        color: #ec1c24;
        background: rgba(236, 28, 36, 0.1);
        padding: 8px;
        border-radius: 8px;
        font-size: 1.1rem;
        width: 32px;
        text-align: center;
    }

    .custom-form-control {
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 20px;
        font-size: 1.05rem;
        background-color: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: #2d3748;
        box-shadow: 0 2px 5px rgba(0,0,0,0.01);
    }

    .custom-form-control:focus {
        border-color: #ec1c24;
        box-shadow: 0 0 0 4px rgba(236, 28, 36, 0.15);
        outline: none;
        transform: translateY(-2px);
    }
    
    .custom-form-control::placeholder {
        color: #a0aec0;
        font-weight: 400;
    }

    /* Fix input group focus styles */
    .input-group {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 14px;
    }
    
    .input-group-text.custom {
        border: 2px solid #e2e8f0;
        border-right: none;
        border-radius: 14px 0 0 14px;
        background-color: #f8fafc;
        color: #4a5568;
        font-weight: 700;
        padding: 0 20px;
        transition: all 0.3s ease;
    }

    .custom-form-control.with-addon {
        border-left: none;
        border-radius: 0 14px 14px 0;
    }
    
    .input-group:focus-within {
        box-shadow: 0 0 0 4px rgba(236, 28, 36, 0.15);
        transform: translateY(-2px);
        border-radius: 14px;
    }
    
    .input-group:focus-within .custom-form-control.with-addon,
    .input-group:focus-within .input-group-text.custom {
        border-color: #ec1c24;
    }

    .btn-modern {
        padding: 15px 35px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1.1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-modern-primary {
        background: linear-gradient(135deg, #ec1c24 0%, #b31217 100%);
        color: white;
        border: none;
        box-shadow: 0 8px 20px rgba(236, 28, 36, 0.25);
    }

    .btn-modern-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(236, 28, 36, 0.35);
        color: white;
    }

    .btn-modern-secondary {
        background: #ffffff;
        color: #4a5568;
        border: 2px solid #cbd5e0;
    }

    .btn-modern-secondary:hover {
        background: #f7fafc;
        border-color: #a0aec0;
        color: #1a202c;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }

    .info-side {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 20px;
        padding: 40px;
        height: 100%;
        border: 1px solid #edf2f7;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        animation: fadeInUp 0.8s ease-out;
    }

    .info-icon {
        font-size: 5rem;
        color: #ec1c24;
        background: rgba(236, 28, 36, 0.05);
        width: 140px;
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 25px;
        box-shadow: inset 0 0 20px rgba(236, 28, 36, 0.1);
        transition: transform 0.3s ease;
    }
    
    .info-side:hover .info-icon {
        transform: scale(1.05) rotate(5deg);
    }

    .info-title {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 15px;
        color: #1a202c;
    }

    .info-desc {
        font-size: 1rem;
        color: #718096;
        line-height: 1.6;
        margin-bottom: 0;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 991px) {
        .info-side {
            margin-bottom: 20px;
            padding: 30px 20px;
        }
    }

    @media (max-width: 768px) {
        .form-header {
            padding: 20px 20px;
        }
        .form-header h5 {
            font-size: 1.2rem;
        }
        .form-body {
            padding: 25px 20px;
        }
        .info-icon {
            width: 90px;
            height: 90px;
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .info-title {
            font-size: 1.2rem;
        }
        .info-desc {
            font-size: 0.95rem;
        }
        .btn-modern {
            width: 100%;
            padding: 12px 20px;
            font-size: 1rem;
        }
        .custom-form-label {
            font-size: 0.9rem;
        }
        .custom-form-control {
            padding: 12px 15px;
            font-size: 1rem;
        }
        /* Make button group direction column */
        .d-flex.gap-3.flex-wrap {
            gap: 10px !important;
            flex-direction: column;
        }
    }
</style>

<!-- Page Title -->
<div class="mb-4">
    <h1 class="page-title"><i class="fas {{ isset($produk) ? 'fa-edit' : 'fa-plus-circle' }} me-2 text-danger"></i> {{ isset($produk) ? "Edit Produk Telkomsel" : "Tambah Produk Baru" }}</h1>
    <p class="text-muted">Lengkapi formulir di bawah ini untuk mengelola katalog produk RoaMAX Anda.</p>
</div>

<!-- Layout Dua Kolom -->
<div class="row">
    <!-- Form Area -->
    <div class="col-lg-8">
        <div class="form-card">
            <div class="form-header">
                <h5><i class="fas fa-box-open"></i> {{ isset($produk) ? "Edit Data Produk" : "Informasi Detail Produk" }}</h5>
            </div>
            
            <div class="form-body">
                <form method="POST" action="{{ isset($produk) ? "/programhaji/admin/produk/{$produk->id}" : "/programhaji/admin/produk" }}">
                    @csrf
                    {{ isset($produk) ? method_field("PUT") : "" }}

                    <div class="mb-4">
                        <label class="custom-form-label">
                            <i class="fas fa-tag"></i> Nama Produk *
                        </label>
                        <input type="text" name="produk_nama" class="form-control custom-form-control @error('produk_nama') is-invalid @enderror" 
                               value="{{ old('produk_nama', $produk->produk_nama ?? '') }}" placeholder="Contoh: Paket RoaMAX Umroh 5GB" required>
                        @error("produk_nama") <small class="text-danger mt-2 d-block fw-bold">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="custom-form-label">
                            <i class="fas fa-align-left"></i> Deskripsi Produk
                        </label>
                        <textarea name="produk_deskripsi" class="form-control custom-form-control @error('produk_deskripsi') is-invalid @enderror" 
                                  rows="4" placeholder="Tuliskan spesifikasi, keunggulan, atau kuota dari paket...">{{ old('produk_deskripsi', $produk->produk_deskripsi ?? '') }}</textarea>
                        @error("produk_deskripsi") <small class="text-danger mt-2 d-block fw-bold">{{ $message }}</small> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="custom-form-label">
                                <i class="fas fa-money-bill-wave"></i> Harga *
                            </label>
                            <div class="input-group">
                                <span class="input-group-text custom">Rp</span>
                                <input type="number" name="produk_harga" class="form-control custom-form-control with-addon @error('produk_harga') is-invalid @enderror" 
                                       value="{{ old('produk_harga', $produk->produk_harga ?? '') }}" placeholder="Contoh: 285000" required>
                            </div>
                            @error("produk_harga") <small class="text-danger mt-2 d-block fw-bold">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="custom-form-label">
                                <i class="fas fa-cubes"></i> Stok *
                            </label>
                            <div class="input-group">
                                <input type="number" name="produk_stok" class="form-control custom-form-control with-addon border-left-fix @error('produk_stok') is-invalid @enderror" 
                                       style="border-left: 2px solid #e2e8f0; border-radius: 14px 0 0 14px;" 
                                       value="{{ old('produk_stok', $produk->produk_stok ?? '') }}" placeholder="Contoh: 100" required>
                                <span class="input-group-text custom border-left-none" style="border-radius: 0 14px 14px 0; border-left: none; border-right: 2px solid #e2e8f0;">Unit</span>
                            </div>
                            <style>
                                /* Fix specific border issue for stock input group */
                                .input-group:focus-within input[name="produk_stok"] {
                                    border-color: #ec1c24 !important;
                                }
                                .input-group:focus-within input[name="produk_stok"] + span {
                                    border-color: #ec1c24 !important;
                                }
                            </style>
                            @error("produk_stok") <small class="text-danger mt-2 d-block fw-bold">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="custom-form-label">
                            <i class="fas fa-hand-holding-usd"></i> Insentif per Produk
                        </label>
                        <div class="input-group">
                            <span class="input-group-text custom">Rp</span>
                            <input type="number" name="produk_insentif" class="form-control custom-form-control with-addon @error('produk_insentif') is-invalid @enderror" 
                                   value="{{ old('produk_insentif', $produk->produk_insentif ?? '') }}" placeholder="Contoh: 5000">
                        </div>
                        @error("produk_insentif") <small class="text-danger mt-2 d-block fw-bold">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex gap-3 flex-wrap">
                        <button type="submit" class="btn-modern btn-modern-primary flex-grow-1 flex-md-grow-0">
                            <i class="fas fa-save"></i> {{ isset($produk) ? "Update Produk" : "Simpan Produk" }}
                        </button>
                        <a href="/programhaji/admin/produk" class="btn-modern btn-modern-secondary flex-grow-1 flex-md-grow-0">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Illustration / Info Area Side -->
    <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="info-side">
            <div class="info-icon" style="background: transparent; box-shadow: none;">
                <img src="{{ asset('admin_asset/img/photos/icon_telkomsel.png') }}" alt="Telkomsel" style="width: 120px; height: 120px; object-fit: contain;">
            </div>
            <h4 class="info-title">{{ isset($produk) ? "Atur Ulang Katalog" : "Tambah ke Etalase" }}</h4>
            <p class="info-desc">
                Pastikan nama, deskripsi, dan harga produk akurat. Informasi yang jelas akan memudahkan *sales* untuk menjualnya kepada pelanggan.
            </p>
            <hr style="width: 50px; border: 2px solid #ec1c24; opacity: 1; border-radius: 5px; margin: 25px auto;">
            <p class="text-muted" style="font-size: 0.9rem;">
                <i class="fas fa-info-circle text-danger me-1"></i> Field bertanda bintang (*) wajib diisi.
            </p>
        </div>
    </div>
</div>

@endsection
