@php
    $layout = Auth::user()->hasRole('kasir') ? 'Kasir.KasirLayouts' : 'Supvis.SupvisLayouts';
@endphp
<x-dynamic-component :component="$layout">
    <div class="container mt-4">
        <h2 class="mb-4">Daftar Transaksi</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="container d-flex justify-content-center align-items-center mt-3">
            <div class="row w-100">
                <div class="col-md-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title text-success">Kasir</h3>
                            <p class="card-text fw-bold">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title text-primary">Total Transaksimu</h3>
                            <p class="card-text fw-bold">Rp {{ number_format($totalPenjualan, 0, ',', '.') }},-</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="transactionTable" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Kasir</th>
                        <th>Tempat Bertugas</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>No. Injeksi</th>
                        <th>Addon Perdana</th>
                        <th>Aktivasi Tanggal</th>
                        <th>Jenis Paket</th>
                        <th>Merchandise</th>
                        <th>Harga</th>
                        <th>Pembayaran</th>
                        <th>Setor</th>
                        <th>Status</th>
                        <th>Bayar?</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="transaksi-body">
                    
                </tbody>
            </table>
        </div>

        <form id="unlunasForm" method="POST" style="display: none;">
            @csrf
            @method('PUT') {{-- Or DELETE / POST depending on your route --}}
        </form>

        <!-- Modal Bayar -->
        <div class="modal fade" id="modalBayar" tabindex="-1" aria-labelledby="modalBayarLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBayarLabel">Konfirmasi Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin memproses pembayaran untuk <strong id="nama_transaksi"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" id="btnLanjutBayar" class="btn btn-success">Lanjutkan</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
        <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    @endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {

            // Delegated: handle checkbox-bayar
            $(document).on('change', '.checkbox-bayar', function () {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const checkbox = $(this);

                Swal.fire({
                    title: 'Konfirmasi Pembayaran',
                    text: `Apakah Anda ingin memproses pembayaran untuk ${nama}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    checkbox.prop('checked', false); // reset checkbox

                    if (result.isConfirmed) {
                        window.location.href = `/programhaji/supvis/transaksi/${id}/bayar`;
                    }
                });
            });

            // Delegated: handle btn-unlunas
            $(document).on('click', '.btn-unlunas', function (e) {
                e.preventDefault();
                const transaksiId = $(this).data('id');
                const actionUrl = `/programhaji/supvis/transaksi/kwitansi/unlunas/${transaksiId}`;

                Swal.fire({
                    title: 'Yakin ubah status menjadi belum lunas?',
                    text: "Transaksi ini akan dianggap belum dibayar.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ubah!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = $('#unlunasForm');
                        form.attr('action', actionUrl);
                        form.submit();
                    }
                });
            });
            
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                
                if (confirm(`Are you sure you want to permanently delete transaction for ${nama}?`)) {
                    $.ajax({
                        url: `/programhaji/supvis/transaksi/${id}/forcedelete`,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Transaction has been permanently deleted');
                            // Refresh the table immediately instead of waiting for interval
                            $.ajax({
                                url: '/programhaji/supvis/approvetransaksi/refresh',
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                    table.clear();
                                    response.transaksi.forEach(function(item) {
                                        // Reuse your existing row creation logic
                                        // For brevity, I've not repeated it here
                                    });
                                    table.draw();
                                }
                            });
                        },
                        error: function(err) {
                            console.error('Delete error:', err);
                            alert('Failed to delete transaction');
                        }
                    });
                }
            });

            function formatDateTime(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                const pad = (n) => n.toString().padStart(2, '0');

                const year = date.getFullYear();
                const month = pad(date.getMonth() + 1); // getMonth() is zero-based
                const day = pad(date.getDate());
                const hours = pad(date.getHours());
                const minutes = pad(date.getMinutes());
                const seconds = pad(date.getSeconds());

                return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            }

            const currentUser = {
                is_superuser: {{ Auth::user()->is_superuser ? 'true' : 'false' }},
                name: @json(Auth::user()->name)
            };
            
            let table;

            if (!$.fn.DataTable.isDataTable('#transactionTable')) {
                table = $('#transactionTable').DataTable({
                    language: {
                        search: "Cari:",
                        zeroRecords: "Loading.. >3 sec -> Tidak ada data ditemukan"
                    },
                    paging: false,
                    info: false,
                    lengthChange: false
                });
            } else {
                table = $('#transactionTable').DataTable(); // just get the instance
            }


            // Function to load transaction data and update the table
            function loadTransactionData() {
                $.ajax({
                    url: '/programhaji/supvis/approvetransaksi/refresh',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        table.clear(); // Clears all rows from the table
        
                        response.transaksi.forEach(function (item) {
                            table.row.add([
                                item.id_transaksi,
                                item.Kasir?.name ?? '',
                                item.sales?.tempat_tugas ?? '-',
                                formatDateTime(item.tanggal_transaksi ?? ''),
                                item.nama_pelanggan ?? '',
                                item.telepon_pelanggan ?? '',
                                item.nomor_injeksi ?? '',
                                item.addon_perdana ? '✓' : '✗',
                                item.aktivasi_tanggal ?? '',
                                item.produk?.produk_nama ?? 'Tidak ditemukan',
                                item.merchandise ?? '',
                                item.produk?.produk_harga_akhir ?? 0,
                                item.metode_pembayaran ?? '',
                                item.is_setor ? 'Sudah' : 'Belum',
                                item.is_paid
                                    ? '<span class="badge bg-success">Lunas</span>'
                                    : '<span class="badge bg-warning text-dark">Belum</span>',
                                item.is_paid
                                    ? '✔'
                                    : `<input type="checkbox" class="checkbox-bayar" data-id="${item.id_transaksi}" data-nama="${item.nama_pelanggan}">`,
                                (function () {
                                    let btns = '';
                                    if (currentUser.is_superuser) {
                                        btns += `<a href="/programhaji/supvis/transaksi/${item.id_transaksi}/edit" class="btn btn-warning btn-sm">Edit</a> `;
                                        btns += `<a href="#" class="btn btn-danger btn-sm btn-delete" data-id="${item.id_transaksi}" data-nama="${item.nama_pelanggan}">Delete</a> `;
                                    }
                                    if (item.is_paid) {
                                        btns += `
                                            <a href="/programhaji/supvis/transaksi/kwitansi/print/${item.id_transaksi}" class="btn btn-success btn-sm" target="_blank">Print</a>
                                            ${currentUser.is_superuser
                                                ? `<a href="#" class="btn btn-warning btn-sm btn-unlunas" data-id="${item.id_transaksi}">Un-Lunas</a>`
                                                : ''}`;
                                    }
                                    return btns;
                                })()
                            ]);
                        });
        
                        table.draw(); // Redraw the DataTable with new data
                    },
                    error: function (err) {
                        console.error('AJAX error:', err);
                    }
                });
            }
        
            // Load data immediately when page loads
            loadTransactionData();
        
            // Then set up periodic refresh
            setInterval(loadTransactionData, 3000);
    
        });
    </script>
@endpush
</x-dynamic-component>


@stack('scripts')
