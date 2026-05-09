<style>
  .glass-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.04);
    overflow: hidden;
  }
  .form-header-bg {
    background: linear-gradient(135deg, var(--tsel-primary, #bc0007) 0%, #8a0005 100%);
    padding: 30px 40px;
    color: white;
    position: relative;
  }
  .form-header-bg::after {
    content: '';
    position: absolute;
    top: 0; right: 0; bottom: 0; left: 0;
    background: url('https://www.transparenttextures.com/patterns/cubes.png') opacity(0.1);
    pointer-events: none;
  }
  .form-title {
    font-size: 1.5rem;
    font-weight: 800;
    margin: 0;
    letter-spacing: -0.5px;
    color: #fff !important;
  }
  .form-subtitle {
    font-size: 0.9rem;
    opacity: 0.8;
    color: #fff !important;
  }
  
  .input-label {
    font-weight: 700;
    color: #444;
    margin-bottom: 8px;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .input-group-text {
    background-color: #f8f9fa;
    border-right: none;
    color: #bc0007;
  }

  .form-control, .form-select {
    border-left: none;
    padding-left: 0;
    border-color: #dee2e6;
    font-weight: 500;
  }

  .form-control:focus, .form-select:focus {
    box-shadow: none;
    border-color: #bc0007;
    background-color: transparent;
  }
  
  .input-group:focus-within .input-group-text,
  .input-group:focus-within .form-control,
  .input-group:focus-within .form-select {
    border-color: #bc0007;
  }

  .btn-submit {
    background: #bc0007;
    color: white;
    font-weight: 700;
    padding: 12px 30px;
    border-radius: 50px;
    border: none;
    transition: all 0.3s;
  }
  .btn-submit:hover {
    background: #8a0005;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(188, 0, 7, 0.3);
  }
  .btn-cancel {
    background: transparent;
    color: #666;
    font-weight: 600;
    padding: 12px 30px;
    border-radius: 50px;
    border: 1px solid #ddd;
    transition: all 0.3s;
  }
  .btn-cancel:hover {
    background: #f8f9fa;
    color: #333;
  }

  @media (max-width: 991px) {
    .btn-submit, .btn-cancel {
        width: 100%;
        margin-bottom: 15px;
    }
  }
</style>

<div class="glass-card mb-5">
  <div class="form-header-bg">
    <h1 class="form-title">
        <i class="fas fa-user-edit me-2"></i> 
        Edit Profil Pengguna
    </h1>
    <div class="form-subtitle">Lengkapi detail akun dengan informasi privasi dan *role* yang sesuai</div>
  </div>

  <form action="{{ route('role_users.update') }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="card-body p-4 p-md-5">
      <div class="row g-5">
        
        <div class="col-lg-8 mx-auto">
            <h5 class="mb-4 text-dark fw-bold border-bottom pb-2">Kredensial & Informasi Akun</h5>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Nama Input -->
            <div class="mb-4">
                <label class="input-label">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           placeholder="Cth: Ahmad Fulan" value="{{ old('name', $roleUsers->name) }}" required>
                </div>
                @error('name')<div class="text-danger small mt-1 fw-bold">{{ $message }}</div>@enderror
            </div>

            <!-- Email & Telepon -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <label class="input-label">Email Aktif</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               placeholder="email@contoh.com" value="{{ old('email', $roleUsers->email) }}" required>
                    </div>
                    @error('email')<div class="text-danger small mt-1 fw-bold">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="input-label">Nomor Telepon/WA</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               placeholder="081234xxxx" value="{{ old('phone', $roleUsers->phone) }}">
                    </div>
                    @error('phone')<div class="text-danger small mt-1 fw-bold">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Role & PIN -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <label class="input-label">Role Akses</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                        <input type="text" class="form-control bg-light" value="{{ ucfirst($roleUsers->role) }}" disabled>
                    </div>
                    <small class="text-muted fst-italic mt-1 d-block"><i class="fas fa-lock"></i> Role tidak dapat diubah untuk akun sendiri.</small>
                </div>

                <div class="col-md-6">
                    <label class="input-label">PIN / Sandi Utama</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="pin" class="form-control @error('pin') is-invalid @enderror" 
                               placeholder="Min. 6 karakter PIN" minlength="6">
                    </div>
                    <small class="text-muted fst-italic mt-1 d-block"><i class="fas fa-info-circle"></i> Kosongkan jika PIN tidak ingin diubah. Min. 6 karakter.</small>
                    @error('pin')<div class="text-danger small mt-1 fw-bold">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex flex-column flex-lg-row gap-3 mt-5">
                <button type="submit" class="btn-submit text-center">
                    <i class="fas fa-paper-plane me-2"></i> Simpan Perubahan Profil
                </button>
                <a href="{{ url()->previous() }}" class="btn-cancel text-center text-decoration-none">
                    Kembali
                </a>
            </div>
        </div>

      </div>
    </div>
  </form>
</div>
