<x-Supvis.SupvisLayouts>
<head>
    
    <style>
        .profile-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .avatar-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
        }

        .avatar-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #2575FC;
            overflow: hidden;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-preview i {
            font-size: 80px;
            color: #ccc;
        }

        .photo-upload-label {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #2575FC;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .photo-upload-label:hover {
            background: #1e66d9;
        }

        .photo-upload-label i {
            color: white;
            font-size: 18px;
        }

        #photo {
            display: none;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-save {
            flex: 1;
            background: #23a0b0;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            color: white;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-save:hover {
            background: #1c828f;
        }

        .btn-cancel {
            flex: 1;
            background: #ff4d4d;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            color: white;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-cancel:hover {
            background: #d43f3f;
        }


        .error {
            color: #ff4d4d;
            font-size: 14px;
            margin-top: 6px;
            margin-bottom: 10px;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-5 mt-5"><strong>Tambah Sales</strong></h1>
        <x-form-card>
        <form id="addSalesForm" action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="profile-section">
                <div class="avatar-container">
                    <div class="avatar-preview">
                        <i class="fas fa-user"></i>
                    </div>
                    <label for="photo" class="photo-upload-label">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" id="photo" name="photo" accept="image/*" onchange="previewImage(this)">
                </div>
            </div>
            <x-form-group 
                label="Nama Sales" 
                name="name" 
                placeholder="Masukkan nama sales" 
                required="true"
                oninput="validateName(this)"
                maxlength="20"
            />
            <div class="error" id="nameError"></div>

            <x-form-group 
                label="Email" 
                name="email" 
                type="email" 
                placeholder="Masukkan email" 
                required="true"
            />
            <div class="error" id="emailError"></div>

            <x-form-group 
                label="Telepon" 
                name="phone" 
                type="tel" 
                placeholder="Masukkan nomor telepon" 
                pattern="[0-9]*" 
                maxlength="15" 
                oninput="validatePhone(this)"
                required="true"
            />
            <div class="error" id="phoneError"></div>

            <x-form-group 
                label="PIN" 
                name="pin" 
                type="text" 
                placeholder="Masukkan PIN (4-6 digit)" 
                maxlength="6" 
                minlength="4" 
                oninput="validatePin(this)"
                required="true"
            />
            <div class="error" id="pinError"></div>
            
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="">Pilih Role</option>
                    <option value="Sales">Sales</option>
                    <option value="Kasir" disabled>Kasir</option>
                </select>
                <div class="error" id="roleError"></div>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-save" onclick="showAlert(event)">Tambah Sales</button>
                <button type="button" class="btn btn-cancel" onclick="confirmCancel()">Batal</button>
            </div>
        </form>
        </x-form-card>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.querySelector('.avatar-preview');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Profile Preview">`;
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '<i class="fas fa-user"></i>';
            }
        }

        // Form validation helper functions
        const ValidationRules = {
            name: {
                validate: (value) => {
                    if (!value) return 'Nama sales wajib diisi';
                    if (value.length > 20) return 'Nama tidak boleh lebih dari 20 karakter';
                    if (!/^[a-zA-Z\s]*$/.test(value)) return 'Nama hanya boleh mengandung huruf dan spasi';
                    return null;
                }
            },

            email: {
                validate: (value) => {
                    if (!value) return 'Email wajib diisi';
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return 'Format email tidak valid';
                    return null;
                }
            },

            photo: {
                validate: (file) => {
                    if (!file) return null;
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    const maxSize = 2048 * 1024;

                    if (!validTypes.includes(file.type)) {
                        return 'File harus berformat JPEG, PNG, atau JPG';
                    }
                    if (file.size > maxSize) {
                        return 'Ukuran file tidak boleh lebih dari 2MB';
                    }
                    return null;
                }
            },

            pin: {
                validate: (value) => {
                    if (!value) return 'PIN wajib diisi';
                    if (!/^\d+$/.test(value)) return 'PIN hanya boleh berisi angka';
                    if (value.length < 4 || value.length > 6) return 'PIN harus terdiri dari 4-6 digit';
                    return null;
                }
            },

            phone: {
                validate: (value) => {
                    if (!value) return 'Nomor telepon wajib diisi';
                    if (!/^\d+$/.test(value)) return 'Nomor telepon hanya boleh berisi angka';
                    if (value.length > 15) return 'Nomor telepon tidak boleh lebih dari 15 digit';
                    return null;
                }
            },

            role: {
                validate: (value) => {
                    if (!value) return 'Role wajib dipilih';
                    const validRoles = ['Sales', 'Kasir'];
                    if (!validRoles.includes(value)) return 'Role tidak valid';
                    return null;
                }
            }
        };

        function validateField(fieldName, value) {
            const error = ValidationRules[fieldName].validate(value);
            const errorElement = document.getElementById(`${fieldName}Error`);
            const inputElement = document.getElementById(fieldName);

            if (error) {
                errorElement.textContent = error;
                inputElement.classList.add('invalid');
                return false;
            } else {
                errorElement.textContent = '';
                inputElement.classList.remove('invalid');
                return true;
            }
        }

        function handleSubmit(event) {
            event.preventDefault();

            const form = document.getElementById('addSalesForm');
            const formData = new FormData(form);
            let isValid = true;

            for (const [fieldName, value] of formData.entries()) {
                if (fieldName === 'photo') {
                    const file = document.getElementById('photo').files[0];
                    if (file && !validateField('photo', file)) {
                        isValid = false;
                    }
                } else if (!validateField(fieldName, value)) {
                    isValid = false;
                }
            }

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                });
                return;
            }

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })

            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    const errorMessages = Object.values(data.errors).flat();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: errorMessages[0]
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                    }).then(() => {
                        window.location.reload();
                    });
                }
            })

            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                });
            });
        }

                    function confirmAdd(event) {
                event.preventDefault();

                let namaSales = document.querySelector('input[name="name"]').value.trim();
                let email = document.querySelector('input[name="email"]').value.trim();
                let telepon = document.querySelector('input[name="phone"]').value.trim();
                let pin = document.querySelector('input[name="pin"]').value.trim();
                let role = document.querySelector('select[name="role"]').value.trim();

                if (namaSales && email && telepon && pin && role) {
                    Swal.fire({
                        title: "Apakah Anda yakin?",
                        text: "Data akan disimpan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Simpan",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById("addSalesForm").submit();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Lengkapi Kolom!",
                        text: "Harap isi semua kolom sebelum melanjutkan.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                }
            }

            document.addEventListener("DOMContentLoaded", function () {
                document.querySelector(".btn-save").addEventListener("click", confirmAdd);
            });

            function confirmCancel() {
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Pengisian akan dibatalkan dan form dikosongkan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, batal!",
                    cancelButtonText: "Tidak",
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("addSalesForm").reset();
                        document.querySelector('.avatar-preview').innerHTML = '<i class="fas fa-user"></i>';
                    }
                });
            }


        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('addSalesForm');

            form.querySelectorAll('input, select').forEach(input => {
                input.addEventListener('input', (e) => {
                    if (e.target.id === 'photo') {
                        validateField('photo', e.target.files[0]);
                    } else {
                        validateField(e.target.id, e.target.value);
                    }
                });

                input.addEventListener('blur', (e) => {
                    if (e.target.id === 'photo') {
                        validateField('photo', e.target.files[0]);
                    } else {
                        validateField(e.target.id, e.target.value);
                    }
                });
            });

            form.removeEventListener('submit', showAlert);
            form.addEventListener('submit', handleSubmit);
        });
    </script>
</body>
</x-Supvis.SupvisLayouts>
