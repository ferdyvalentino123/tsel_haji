@extends('admin.layout')
@section('title', 'Monitor Transaksi Void')
@section('content')
    <div class="container-fluid" style="background: #f8f9fa;">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #bc0007 0%, #98292dff 100%);">
                    <div class="card-body p-4 text-white d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-1"><i class="fas fa-trash-alt text-whte me-2"></i> Monitor Transaksi Void</h4>
                            <p class="mb-0 opacity-75">Jejak audit transaksi yang dibatalkan oleh sales untuk pengawasan keamanan.</p>
                        </div>
                        <div class="text-end d-none d-md-block">
                            <h3 class="fw-bold mb-0 text-white">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
                            <small class="opacity-75">Total Potensi Nilai Void</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" id="search-input" class="form-control border-start-0 ps-0" placeholder="Cari Sales, Pelanggan, atau ID...">
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <select id="filter-transaksi" class="form-select border-0 bg-light">
                                    <option value="all">Semua Waktu</option>
                                    <option value="1">Hari Ini</option>
                                    <option value="7">7 Hari Terakhir</option>
                                    <option value="30">1 Bulan Terakhir</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Void List -->
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover align-middle bg-white rounded-4 overflow-hidden shadow-sm" id="dataTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">ID Transaksi</th>
                                <th>Tanggal</th>
                                <th>Sales Person</th>
                                <th>Pelanggan</th>
                                <th>Paket RoaMAX</th>
                                <th>Nilai</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($groupedTransaksi as $tanggal => $items)
                                <tr class="bg-light bg-opacity-50">
                                    <td colspan="7" class="fw-bold text-muted ps-4 py-3">
                                        <i class="fas fa-calendar-day me-2"></i> {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}
                                    </td>
                                </tr>
                                @foreach ($items as $item)
                                    <tr class="void-row">
                                        <td class="ps-4 fw-bold id-transaksi text-muted">{{ $item->id_transaksi }}</td>
                                        <td class="tanggal small text-muted">{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('H:i') }}</td>
                                        <td class="nama-sales">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="fas fa-user-tie text-secondary"></i>
                                                </div>
                                                <span class="fw-bold">{{ $item->nama_sales }}</span>
                                            </div>
                                        </td>
                                        <td class="nama-pelanggan small">{{ $item->nama_pelanggan }}</td>
                                        <td class="jenis-paket small text-truncate" style="max-width: 150px;">{{ $item->produk ? $item->produk->produk_nama : '-' }}</td>
                                        <td class="harga fw-bold text-danger">Rp {{ number_format($item->produk ? $item->produk->produk_harga_akhir : 0, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Restore Button (Coming Soon logic or actual restore) -->
                                                <form action="{{ route('transaksi.toggle-void', $item->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="is_void" value="0">
                                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3" title="Pulihkan">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <!-- Force Delete -->
                                                <form action="{{ route('admin.monitor.destroy', $item->id) }}" method="POST" 
                                                      onsubmit="return confirm('Hapus PERMANEN? Data tidak akan bisa dikembalikan lagi!')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Hapus Permanen">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <img src="https://illustrations.popsy.co/red/empty-folder.svg" alt="Empty" style="width: 150px; opacity: 0.5;">
                                        <p class="text-muted mt-3">Tidak ada transaksi yang dibatalkan hari ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#search-input').on('keyup', function () {
                const value = $(this).val().toLowerCase();
                $('#dataTable tbody tr.void-row').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            $('#filter-transaksi').on('change', function () {
                const filterValue = $(this).val();
                const today = new Date();
                
                $('#dataTable tbody tr.void-row').show(); 

                if (filterValue !== 'all') {
                    const days = parseInt(filterValue);
                    const filterDate = new Date();
                    filterDate.setDate(today.getDate() - days);

                    $('#dataTable tbody tr.void-row').filter(function () {
                        const transactionDate = new Date($(this).find('.tanggal').text());
                        return transactionDate < filterDate;
                    }).hide();
                }
            });
        });
    </script>
    @endpush
@endsection
