<x-pelanggan.layouts>
    <style>
        :root {
            --tsel-red: #ec1c24;
            --tsel-dark: #b31217;
            --tsel-gradient: linear-gradient(135deg, #ec1c24 0%, #b31217 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: rgba(255, 255, 255, 0.3);
        }

        .profile-container {
            max-width: 900px;
            margin: 0 auto;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            padding-bottom: 50px;
        }

        .profile-header {
            background: var(--tsel-gradient);
            border-radius: 24px;
            padding: 50px 40px;
            color: #fff;
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(236, 28, 36, 0.25);
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url("{{ asset('admin_asset/img/photos/layer 1.png') }}");
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            z-index: 0;
            pointer-events: none;
        }

        .header-decor {
            position: absolute;
            top: 25px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 80px;
            padding: 0 40px;
            opacity: 0.25;
            font-size: 1.8rem;
            pointer-events: none;
            z-index: 0;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 5px solid var(--glass-border);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2), inset 0 0 15px rgba(236, 28, 36, 0.1);
            position: relative;
            z-index: 1;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .profile-avatar:hover {
            transform: scale(1.08) rotate(5deg);
        }

        .profile-avatar i {
            font-size: 3.2rem;
            background: var(--tsel-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .profile-header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
            text-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .profile-header p {
            font-size: 1rem;
            opacity: 0.95;
            font-weight: 600;
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(0,0,0,0.2);
            padding: 8px 24px;
            border-radius: 30px;
            backdrop-filter: blur(5px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .profile-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 45px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0,0,0,0.03);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 35px;
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            padding-bottom: 15px;
            border-bottom: 2px dashed rgba(236, 28, 36, 0.2);
        }

        .section-title i {
            font-size: 1.6rem;
            color: var(--tsel-red);
            background: rgba(236, 28, 36, 0.1);
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            box-shadow: 0 4px 10px rgba(236, 28, 36, 0.1);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .info-item {
            background: #ffffff;
            padding: 25px;
            border-radius: 20px;
            border: 1px solid #edf2f7;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            z-index: 1;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }

        .info-item::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(236, 28, 36, 0.04) 0%, transparent 100%);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .info-item:hover {
            transform: translateY(-8px);
            border-color: rgba(236, 28, 36, 0.15);
            box-shadow: 0 15px 35px rgba(236, 28, 36, 0.08);
        }

        .info-item:hover::before {
            opacity: 1;
        }

        .info-label {
            font-size: 0.85rem;
            color: #718096;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .info-label i {
            color: var(--tsel-red);
            font-size: 1.2rem;
            opacity: 0.9;
            transition: transform 0.3s ease;
            background: rgba(236, 28, 36, 0.1);
            padding: 6px;
            border-radius: 8px;
        }
        
        .info-item:hover .info-label i {
            transform: scale(1.15) rotate(5deg);
            background: var(--tsel-red);
            color: white;
            box-shadow: 0 4px 10px rgba(236, 28, 36, 0.3);
        }

        .info-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2d3748;
            word-break: break-word;
            line-height: 1.4;
            padding-left: 4px;
        }

        /* Form Enhancements */
        .form-label {
            font-weight: 700;
            color: #4a5568;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.05rem;
        }

        .form-label i {
            color: var(--tsel-red);
            background: rgba(236, 28, 36, 0.1);
            padding: 10px;
            border-radius: 10px;
            font-size: 1.1rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 18px 24px;
            font-size: 1.05rem;
            font-weight: 500;
            color: #2d3748;
            background-color: #f8fafc;
            transition: all 0.3s ease;
            box-shadow: none;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: var(--tsel-red);
            box-shadow: 0 0 0 5px rgba(236, 28, 36, 0.15);
            outline: none;
            transform: translateY(-2px);
        }
        
        .form-control::placeholder {
            color: #a0aec0;
            font-weight: 400;
        }

        /* Buttons */
        .btn-edit, .btn-save {
            background: var(--tsel-gradient);
            color: #fff;
            border: none;
            padding: 18px 45px;
            border-radius: 18px;
            font-weight: 700;
            font-size: 1.15rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(236, 28, 36, 0.3);
            cursor: pointer;
            letter-spacing: 0.5px;
            text-decoration: none;
        }

        .btn-edit:hover, .btn-save:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(236, 28, 36, 0.4);
            color: #fff;
        }

        .btn-edit i, .btn-save i {
            font-size: 1.3rem;
            transition: transform 0.3s ease;
        }

        .btn-edit:hover i, .btn-save:hover i {
            transform: scale(1.2) rotate(-5deg);
        }

        .btn-cancel {
            background: #ffffff;
            color: #4a5568;
            border: 2px solid #e2e8f0;
            padding: 18px 45px;
            border-radius: 18px;
            font-weight: 700;
            font-size: 1.15rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background: #f8fafc;
            border-color: #cbd5e0;
            color: #1a202c;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        
        .btn-cancel:hover i {
            transform: translateX(-4px);
            transition: transform 0.3s ease;
        }

        /* Alerts */
        .alert-custom {
            border-radius: 18px;
            padding: 20px 25px;
            margin-bottom: 35px;
            border: none;
            display: flex;
            align-items: center;
            gap: 18px;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            animation: fadeInDown 0.5s ease-out;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border-left: 6px solid #22c55e;
        }
        
        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border-left: 6px solid #ef4444;
        }

        .alert-custom i {
            font-size: 1.8rem;
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
            opacity: 0;
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .edit-mode-toggle {
            text-align: center;
            margin: 40px 0;
        }

        textarea.form-control {
            min-height: 140px;
            resize: vertical;
        }

        /* Responsive tweaks */
        @media (max-width: 768px) {
            .profile-header {
                padding: 40px 20px;
                border-radius: 20px;
            }
            .profile-header h1 {
                font-size: 2.2rem;
            }
            .profile-card {
                padding: 30px 20px;
                border-radius: 20px;
            }
            .btn-edit, .btn-save, .btn-cancel {
                width: 100%;
                margin-bottom: 12px;
            }
            .action-buttons {
                flex-direction: column !important;
                gap: 0 !important;
            }
        }
    </style>

    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header fade-in-up">
            <div class="header-decor">
                <i class="fas fa-kaaba"></i>
                <i class="fas fa-mosque"></i>
                <i class="fas fa-plane-departure"></i>
            </div>
            <div class="profile-avatar">
                <i class="fas fa-user-astronaut"></i>
            </div>
            <h1>{{ $user->name }}</h1>
            <p><i class="fas fa-id-badge"></i> Pelanggan Telkomsel Roamax Haji</p>
        </div>

        @if(session('warning'))
        <div class="alert alert-warning alert-custom alert-dismissible fade show fade-in-up delay-1" role="alert" style="background-color: #fffbeb; color: #92400e; border-left: 6px solid #f59e0b;">
            <i class="fas fa-exclamation-triangle"></i>
            <div>{{ session('warning') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success alert-custom alert-dismissible fade show fade-in-up delay-1" role="alert">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-custom alert-dismissible fade show fade-in-up delay-1" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-custom alert-dismissible fade show fade-in-up delay-1" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- View Mode -->
        <div id="viewMode">
            <div class="profile-card fade-in-up delay-2">
                <h3 class="section-title">
                    <i class="fas fa-address-card"></i>
                    Informasi Biodata
                </h3>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-id-badge"></i>
                            Nama Lengkap
                        </div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>
                            Nomor Telepon
                        </div>
                        <div class="info-value">{{ $user->phone ?? 'Belum diisi' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-user-tie"></i>
                            Role Akun
                        </div>
                        <div class="info-value">{{ ucfirst($user->role) }}</div>
                    </div>
                </div>

                <div class="info-item" style="margin-bottom: 0;">
                    <div class="info-label">
                        <i class="fas fa-map-marker-alt"></i>
                        Alamat
                    </div>
                    <div class="info-value">{{ $user->tempat_tugas ?? 'Belum diisi' }}</div>
                </div>
            </div>

            <div class="edit-mode-toggle fade-in-up delay-3">
                <button type="button" class="btn btn-edit" onclick="toggleEditMode()">
                    <i class="fas fa-user-edit"></i> Edit Profil
                </button>
            </div>
        </div>

        <!-- Edit Mode -->
        <div id="editMode" style="display: none;">
            <div class="profile-card fade-in-up delay-2">
                <h3 class="section-title">
                    <i class="fas fa-user-edit"></i>
                    Edit Biodata
                </h3>

                <form action="{{ route('pelanggan.profil.update') }}" method="POST" id="profileForm">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-user"></i> Nama Lengkap
                        </label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-phone"></i> Nomor Telepon
                        </label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" 
                               placeholder="Contoh: 081234567890" required>
                        <small class="text-muted d-block mt-2 font-weight-bold" style="padding-left: 5px; color: #718096;">Format: Min 10 angka (Contoh: 081234567890)</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"></i> Alamat
                        </label>
                        <textarea class="form-control" name="tempat_tugas" 
                                  placeholder="Masukkan alamat lengkap Anda...">{{ old('tempat_tugas', $user->tempat_tugas) }}</textarea>
                    </div>

                    <div class="text-center action-buttons" style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-top: 40px;">
                        <button type="button" class="btn btn-cancel" onclick="toggleEditMode()">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleEditMode() {
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');
            
            if (viewMode.style.display === 'none') {
                // Return to view mode
                viewMode.style.display = 'block';
                editMode.style.display = 'none';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                // Go to edit mode
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        // Auto show edit mode if there are validation errors or warning
        @if($errors->any() || session('warning'))
        document.addEventListener('DOMContentLoaded', function() {
            toggleEditMode();
        });
        @endif

        // Konfirmasi sebelum submit
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: 'Pastikan data yang Anda masukkan sudah benar.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ec1c24',
                cancelButtonColor: '#cbd5e0',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                customClass: {
                    cancelButton: 'text-dark'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>

</x-pelanggan.layouts>
