@extends("admin.layout")
@section("title", isset($merchandise) ? "Edit Merchandise" : "Tambah Merchandise")
@section("content")

<div class="mb-4">
    <a href="{{ route('admin.merchandise.index') }}" class="btn btn-link text-danger p-0 text-decoration-none">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <h1 class="page-title mt-2">
        <i class="fas {{ isset($merchandise) ? 'fa-edit' : 'fa-plus-circle' }}"></i> 
        {{ isset($merchandise) ? "Edit Merchandise" : "Tambah Merchandise Baru" }}
    </h1>
</div>

<div class="row">
    <div class="col-12 col-lg-8">
        <div class="content-card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle me-2" style="color: #bc0007;"></i>Informasi Merchandise</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ isset($merchandise) ? route('admin.merchandise.update', $merchandise->id) : route('admin.merchandise.store') }}" method="POST">
                    @csrf
                    @if(isset($merchandise))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Merchandise</label>
                        <input type="text" name="merch_nama" class="form-control @error('merch_nama') is-invalid @enderror" 
                               value="{{ old('merch_nama', $merchandise->merch_nama ?? '') }}" 
                               placeholder="Contoh: Payung Telkomsel" required>
                        @error('merch_nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Detail / Deskripsi</label>
                        <textarea name="merch_detail" class="form-control @error('merch_detail') is-invalid @enderror" 
                                  rows="4" placeholder="Jelaskan detail merchandise..." required>{{ old('merch_detail', $merchandise->merch_detail ?? '') }}</textarea>
                        @error('merch_detail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Stok Tersedia</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-boxes"></i></span>
                                <input type="number" name="merch_stok" class="form-control @error('merch_stok') is-invalid @enderror" 
                                       value="{{ old('merch_stok', $merchandise->merch_stok ?? 0) }}" 
                                       min="0" required>
                            </div>
                            @error('merch_stok')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4 opacity-50">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.merchandise.index') }}" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="fas fa-save me-2"></i> {{ isset($merchandise) ? "Simpan Perubahan" : "Simpan Merchandise" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="content-card bg-light border-0 shadow-none">
            <div class="card-body p-4 text-center">
                <img src="{{ asset('admin_asset/img/photos/icon_telkomsel.png') }}" alt="Preview" class="img-fluid mb-4" style="max-height: 200px;">
                <h6 class="fw-bold">Tips Manajemen Stok</h6>
                <p class="text-muted small">Pastikan jumlah stok yang diinput sesuai dengan fisik yang ada di gudang asrama untuk memudahkan Sales saat distribusi.</p>
            </div>
        </div>
    </div>
</div>

@endsection
