<x-Sales.SalesLayouts>
    
    <style>
        body {
            background: linear-gradient(135deg, #bc0007 0%, #8c0005 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .dashboard {
            padding: 20px;
        }

        .filter-box {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 25px;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .filter-box label {
            font-weight: 700;
            color: #333;
            margin-right: 15px;
        }

        .filter-select,
        .search-input {
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 10px;
            border: 1px solid #dee2e6;
            margin: 5px;
            width: 250px;
            transition: all 0.3s;
        }

        .filter-select:focus,
        .search-input:focus {
            border-color: #bc0007;
            box-shadow: 0 0 0 0.25rem rgba(188, 0, 7, 0.1);
            outline: none;
        }

        .search-container {
            position: relative;
        }

        .search-container i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #bc0007;
            cursor: pointer;
        }

        .table-container {
            overflow-x: auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 18px 15px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }

        th {
            background: #bc0007;
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .date-row {
            background: #f8f9fa;
            font-weight: 800;
            color: #bc0007;
            text-align: left;
        }

        .total-row {
            background: #333;
            font-weight: 800;
            color: white;
        }

        .total-row td {
            border-bottom: none;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #999;
            background: white;
            border-radius: 15px;
            display: none;
        }

        .badge-activated {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .dashboard {
                padding: 10px;
            }
            .filter-box {
                flex-direction: column;
                align-items: stretch;
                padding: 15px;
            }

            .filter-select,
            .search-input {
                width: 100%;
                margin: 5px 0;
            }

            th, td {
                padding: 12px 8px;
                font-size: 11px;
            }

            .date-row th {
                padding-left: 10px !important;
                font-size: 12px;
            }

            .btn-download-nota {
                padding: 4px 8px !important;
                font-size: 10px !important;
                gap: 4px !important;
            }
        }

        .voided td {
            text-decoration: line-through;
            color: #ccc;
            background-color: #fafafa;
        }

        .btn-download-nota {
            background: #fff;
            color: #1a1c1c;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            border: 1px solid #bc0007;
            cursor: pointer;
            font-size: 0.75rem;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-download-nota:hover {
            background: #bc0007;
            color: #fff;
            border-color: #bc0007;
            text-decoration: none;
        }

        .activated-row {
            background-color: #f0fff4 !important; /* Hijau muda transparan */
        }
        
        .activated-row td {
            color: #2f855a !important;
        }
    </style>

    <div class="container mt-5">
        <div class="filter-box">
            <label for="filter-transaksi">Filter Transaksi: </label>
            <select id="filter-transaksi" class="filter-select">
                <option value="all">Semua Transaksi</option>
                <option value="1">Hari Ini</option>
                <option value="7">7 Hari Terakhir</option>
                <option value="30">1 Bulan Terakhir</option>
                <option value="365">1 Tahun Terakhir</option>
            </select>
            <div class="search-container">
                <input type="text" id="search-input" class="search-input" placeholder="Search">
                <i class="fas fa-search"></i>
            </div>
        </div>

        <h3 class="mt-4 text-dark fw-bold"><i class="fas fa-archive me-2"></i> Transaksi Belum Di Setor </h3>
        <div class="table-container">
            <table id="dataTable">
                <thead>
                    <tr>
                        <th>Status Injeksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>ID Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>No. Tlp Pelanggan</th>
                        <th>No. Injeksi</th>
                        <th>Aktivasi Tanggal</th>
                        <th>Jenis Paket</th>
                        <th>Merchandise</th>
                        <th>Nama Sales</th>
                        <th>Nomor Sales</th>
                        <th>Metode Pembayaran</th>
                        <th>Harga</th>
                        <th>Insentif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($groupedTransaksi->isEmpty())
                        <tr>
                            <td colspan="14">Tidak ada transaksi yang ditemukan.</td>
                        </tr>
                    @else
                        @foreach ($groupedTransaksi as $tanggal => $items)
                            @php
                                $firstItem = $items->first(); // Ambil ID transaksi pertama untuk mewakili grup
                            @endphp
                                <th colspan="15" style="text-align: left; padding-left: 20px; background: #fdf2f2;">
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-danger me-3 btn-setor-tanggal" data-date="{{ $tanggal }}">
                                            <i class="fas fa-paper-plane me-1"></i> Setor Tanggal Ini
                                        </button>
                                        <span class="text-dark">Tanggal: <strong>{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</strong></span>
                                    </div>
                                </th>
                            @foreach ($items as $item)
                                <tr class="transaksi-row {{ $item->trashed() ? 'voided' : '' }} {{ $item->is_activated ? 'activated-row' : '' }}"
                                    data-date="{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('Y-m-d') }}"
                                    data-id="{{ $item->id }}">
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="form-check p-0 m-0">
                                                <input type="checkbox" class="activate-checkbox" 
                                                       style="width: 22px; height: 22px; cursor: pointer;"
                                                       data-id="{{ $item->id }}" 
                                                       {{ $item->is_activated ? 'checked' : '' }}>
                                            </div>
                                            <span class="badge {{ $item->is_activated ? 'bg-success' : 'bg-secondary' }} mt-1" 
                                                  id="status-badge-{{ $item->id }}"
                                                  style="font-size: 0.6rem; min-width: 60px;">
                                                {{ $item->is_activated ? 'INJECTED' : 'PENDING' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="tanggal">
                                        {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y H:i') }}</td>
                                    <td class="id-transaksi">{{ $item->id_transaksi }}</td>
                                    <td class="nama-pelanggan">{{ $item->nama_pelanggan }}</td>
                                    <td class="nomor-pelanggan">{{ $item->telepon_pelanggan }}</td>
                                    <td class="nomor-injeksi">
                                        {{ $item->nomor_injeksi }}
                                        @if($item->addon_perdana)
                                            <span class="badge bg-success mt-1" style="font-size: 0.65rem; display: block; width: fit-content;">+ Perdana Baru</span>
                                        @endif
                                    </td>
                                    <td class="aktivasi-tanggal">{{ $item->aktivasi_tanggal }}</td>
                                    <td class="jenis-paket">{{ $item->jenis_paket }}</td>
                                    <td class="merchandise">{{ $item->merchandise }}</td>
                                    <td class="nama-sales">{{ $item->nama_sales }}</td>
                                    <td class="nomor-telepon">{{ $item->nomor_telepon }}</td>
                                    <td class="metode-pembayaran">{{ $item->metode_pembayaran }}</td>
                                    <td class="harga">{{ $item->produk ? $item->produk->produk_harga_akhir : 0 }}</td>
                                    <td class="insentif">{{ $item->produk ? $item->produk->produk_insentif : 0 }}</td>
                                    <td class="text-nowrap" style="width: 100px;">
                                        <div class="d-flex gap-2 justify-content-center align-items-center">
                                            <button type="button" class="btn-download-nota btn-lihat-modal" data-transaksi-id="{{ $item->id }}" title="Lihat Nota" style="width: 35px; height: 35px; padding: 0;">
                                                <i class="fas fa-receipt"></i>
                                            </button>
                                            @if(!$item->trashed())
                                                <button type="button" class="btn-download-nota btn-hapus-transaksi text-danger border-danger" data-id="{{ $item->id }}" title="Hapus Transaksi" style="width: 35px; height: 35px; padding: 0;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn-download-nota btn-hapus-transaksi text-success border-success" data-id="{{ $item->id }}" title="Pulihkan Transaksi" style="width: 35px; height: 35px; padding: 0;">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr class="total-row" id="total-row">
                        <td colspan="12">Total Keseluruhan:</td>
                        <td id="total-penjualan">{{ $totalPenjualan }}</td>
                        <td id="total-insentif">{{ $totalInsentif }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <h3 class="mt-4 text-dark fw-bold"><i class="fas fa-archive me-2"></i> Riwayat Setoran Selesai</h3>
        <div class="table-container">
            <table id="setoranTable">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Aktivasi</th>
                        <th>ID Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Paket</th>
                        <th>Metode</th>
                        <th>Harga</th>
                        <th>Insentif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($groupedSetoran->isEmpty())
                        <tr>
                            <td colspan="9" class="py-4 text-muted">Belum ada riwayat setoran.</td>
                        </tr>
                    @else
                        @foreach ($groupedSetoran as $tanggal => $items)
                            <tr class="date-row">
                                <th colspan="9" style="background: #f8f9fa; color: #28a745; padding-left: 20px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-check-circle me-2"></i> Setoran Tanggal: <strong>{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</strong></span>
                                        <span class="badge bg-success">Total: Rp {{ number_format($setoranTotals[$tanggal]['totalPenjualan'], 0, ',', '.') }}</span>
                                    </div>
                                </th>
                            </tr>
                            @foreach ($items as $item)
                                <tr>
                                    <td class="status-activation">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input activate-checkbox" 
                                                       type="checkbox" 
                                                       data-id="{{ $item->id }}"
                                                       {{ $item->is_activated ? 'checked' : '' }}
                                                       style="transform: scale(1.2); cursor: pointer;">
                                            </div>
                                            <span class="badge {{ $item->is_activated ? 'bg-success' : 'bg-secondary' }} mt-1" 
                                                  id="status-badge-{{ $item->id }}"
                                                  style="font-size: 0.6rem; min-width: 60px;">
                                                {{ $item->is_activated ? 'INJECTED' : 'PENDING' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="small">{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y H:i') }}</td>
                                    <td class="small fw-bold text-primary">{{ \Carbon\Carbon::parse($item->aktivasi_tanggal)->format('d M Y') }}</td>
                                    <td class="small fw-bold">{{ $item->id_transaksi }}</td>
                                    <td>{{ $item->nama_pelanggan }}</td>
                                    <td class="small">
                                        {{ $item->produk ? $item->produk->produk_nama : $item->jenis_paket }}
                                    </td>
                                    <td>{{ $item->metode_pembayaran }}</td>
                                    <td class="fw-bold">Rp {{ number_format($item->produk ? $item->produk->produk_harga_akhir : 0, 0, ',', '.') }}</td>
                                    <td class="text-success small">Rp {{ number_format($item->produk ? $item->produk->produk_insentif : 0, 0, ',', '.') }}</td>
                                    <td class="text-nowrap" style="width: 50px;">
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn-download-nota btn-lihat-modal" data-transaksi-id="{{ $item->id }}" title="Lihat Nota" style="width: 35px; height: 35px; padding: 0;">
                                                <i class="fas fa-receipt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Handle Lihat Modal with SweetAlert2
            document.querySelectorAll('.btn-lihat-modal').forEach(button => {
                button.addEventListener('click', function() {
                    const transaksiId = this.dataset.transaksiId;
                    const downloadUrl = `/programhaji/sales/transaksi/print/${transaksiId}`;
                    
                    // Show loading state
                    Swal.fire({
                        title: 'Menyiapkan Nota...',
                        html: `
                            <div class="d-flex flex-column align-items-center justify-content-center py-3">
                                <div class="spinner-border text-danger mb-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-muted">Mohon tunggu sebentar</p>
                            </div>
                        `,
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    
                    // Fetch nota content
                    fetch(downloadUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text();
                    })
                    .then(html => {
                        Swal.fire({
                            title: '<i class="fas fa-receipt text-danger"></i> Detail Nota',
                            html: `<div style="text-align: left;">${html}</div>`,
                            showCancelButton: true,
                            confirmButtonColor: '#bc0007',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: '<i class="fas fa-print"></i> Cetak Langsung',
                            cancelButtonText: 'Tutup',
                            width: 'auto',
                            customClass: {
                                popup: 'rounded-4'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const printUrl = `/programhaji/sales/transaksi/print/${transaksiId}?action=print-html`;
                                window.open(printUrl, '_blank');
                            }
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal memuat nota. Silakan coba lagi nanti.'
                        });
                        console.error('Error:', error);
                    });
                });
            });

            
            document.querySelectorAll('.activate-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('click', function(e) {
                    e.preventDefault(); // Stop default check action to handle via SweetAlert
                    
                    const cb = this;
                    const transaksiId = cb.getAttribute('data-id');
                    const isNowChecked = cb.checked;
                    const actionText = isNowChecked ? "Tandai paket sudah diinjeksi?" : "Batalkan status injeksi?";
                    const confirmColor = isNowChecked ? "#28a745" : "#6c757d";

                    Swal.fire({
                        title: "Konfirmasi Status",
                        text: actionText,
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Benar",
                        cancelButtonText: "Kembali",
                        confirmButtonColor: confirmColor,
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/programhaji/transaksi/${transaksiId}/toggle-activate`, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    is_activated: isNowChecked ? 1 : 0
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    cb.checked = isNowChecked;
                                    const row = cb.closest('tr');
                                    const badge = document.getElementById(`status-badge-${transaksiId}`);
                                    
                                    if (isNowChecked) {
                                        row.classList.add('activated-row');
                                        badge.className = 'badge bg-success mt-1';
                                        badge.textContent = 'INJECTED';
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: 'Paket ditandai sudah diinjeksi.',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                    } else {
                                        row.classList.remove('activated-row');
                                        badge.className = 'badge bg-secondary mt-1';
                                        badge.textContent = 'PENDING';
                                    }
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire("Gagal!", "Terjadi kesalahan koneksi.", "error");
                            });
                        }
                    });
                });
            });
            
            
            document.querySelectorAll(".void-checkbox").forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    let row = this.closest(".transaksi-row");
                    let transaksiId = this.getAttribute("data-id");

                    if (this.checked) {
                        row.classList.add("voided");
                    } else {
                        row.classList.remove("voided");
                    }

                    fetch(`/transaksi/${transaksiId}/toggle-void`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            is_void: this.checked
                        })
                    });
                });

                if (checkbox.checked) {
                    checkbox.closest(".transaksi-row").classList.add("voided");
                }
            });

            // Handle Setor per Tanggal
                                document.querySelectorAll('.btn-setor-tanggal').forEach(function(button) {
                                    button.addEventListener('click', function() {
                                        const date = this.getAttribute('data-date');
                                        
                                        Swal.fire({
                                            title: "Setor Transaksi?",
                                            text: "Semua transaksi pada tanggal " + date + " akan disetorkan ke Admin. Aksi ini tidak dapat dibatalkan.",
                                            icon: "question",
                                            showCancelButton: true,
                                            confirmButtonText: "Ya, Setorkan",
                                            cancelButtonText: "Batal",
                                            confirmButtonColor: "#bc0007"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                fetch('/programhaji/sales/transaksi/setor', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: JSON.stringify({ date: date })
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if(data.success) {
                                                        Swal.fire("Berhasil!", "Transaksi telah disetorkan ke Admin.", "success")
                                                            .then(() => location.reload());
                                                    }
                                                })
                                                .catch(error => console.error('Error:', error));
                                            }
                                        });
                                    });
                                });

                                // Handle Hapus/Restore Transaksi Individual
                                document.querySelectorAll('.btn-hapus-transaksi').forEach(function(button) {
                                    button.addEventListener('click', function() {
                                        const id = this.getAttribute('data-id');
                                        const isRestore = this.classList.contains('text-success');
                                        
                                        Swal.fire({
                                            title: isRestore ? "Pulihkan Transaksi?" : "Hapus Transaksi?",
                                            text: isRestore ? "Transaksi akan dikembalikan ke daftar aktif." : "Transaksi ini akan ditandai sebagai dihapus (void).",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonText: isRestore ? "Ya, Pulihkan" : "Ya, Hapus",
                                            confirmButtonColor: isRestore ? "#28a745" : "#dc3545"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                fetch(`/programhaji/transaksi/${id}/toggle-void`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: JSON.stringify({ is_void: !isRestore })
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    Swal.fire("Berhasil!", "Status transaksi diperbarui.", "success")
                                                        .then(() => location.reload());
                                                })
                                                .catch(error => console.error('Error:', error));
                                            }
                                        });
                                    });
                                });


            document.getElementById('search-input').addEventListener('keyup', function() {
                const value = this.value.toLowerCase();
                let hasResults = false;

                document.querySelectorAll('#dataTable tbody tr').forEach(row => {
                    const isVisible = row.textContent.toLowerCase().includes(value);
                    row.style.display = isVisible ? '' : 'none';
                    if (isVisible) hasResults = true;
                });

                document.querySelector('.no-results')?.style && (document.querySelector('.no-results').style.display = hasResults ? 'none' : '');
                document.getElementById('total-row').style.display = hasResults ? '' : 'none';

                calculateTotals();
            });

            function calculateTotals() {
                let totalPenjualan = 0;
                let totalInsentif = 0;

                document.querySelectorAll('#dataTable tbody tr:visible').forEach(row => {
                    const hargaText = row.querySelector('.harga')?.textContent.trim() || "0";
                    const insentifText = row.querySelector('.insentif')?.textContent.trim() || "0";
                    const harga = parseFloat(hargaText.replace(/[^\d.-]/g, '')) || 0;
                    const insentif = parseFloat(insentifText.replace(/[^\d.-]/g, '')) || 0;
                    totalPenjualan += harga;
                    totalInsentif += insentif;
                });

                document.getElementById('total-penjualan').textContent = `Rp ${totalPenjualan.toLocaleString('id-ID')}`;
                document.getElementById('total-insentif').textContent = `Rp ${totalInsentif.toLocaleString('id-ID')}`;
            }

            calculateTotals();
        });
    </script>

</x-Sales.SalesLayouts>