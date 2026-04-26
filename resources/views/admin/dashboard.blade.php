@extends("admin.layout")
@section("title", "Dashboard Admin")
@section("content")

<!-- Page Title -->
<div class="mb-4">
  <h1 class="page-title"><i class="fas fa-chart-pie"></i> Dashboard Admin</h1>
</div>

<!-- Statistics Cards -->
<div class="row">
  <!-- Total Products -->
  <div class="col-lg-3 col-md-6">
    <div class="stat-card h-100">
      <div class="stat-icon stat-icon-1">
        <i class="fas fa-box"></i>
      </div>
      <div class="stat-info">
        <div class="stat-label">Total Produk</div>
        <div class="stat-value">{{ $totalProducts }}</div>
      </div>
    </div>
  </div>

  <!-- Total Transactions -->
  <div class="col-lg-3 col-md-6">
    <div class="stat-card h-100">
      <div class="stat-icon stat-icon-2">
        <i class="fas fa-credit-card"></i>
      </div>
      <div class="stat-info">
        <div class="stat-label">Total Transaksi</div>
        <div class="stat-value">{{ $totalTransactions }}</div>
      </div>
    </div>
  </div>

  <!-- Total Revenue -->
  <div class="col-lg-3 col-md-6">
    <div class="stat-card h-100">
      <div class="stat-icon stat-icon-3">
        <i class="fas fa-rupiah-sign"></i>
      </div>
      <div class="stat-info">
        <div class="stat-label">Pendapatan Total</div>
        <div class="stat-value truncate-value">Rp {{ number_format($totalRevenue, 0, ",", ".") }}</div>
      </div>
    </div>
  </div>

  <!-- Total Stock -->
  <div class="col-lg-3 col-md-6">
    <div class="stat-card h-100">
      <div class="stat-icon stat-icon-4">
        <i class="fas fa-warehouse"></i>
      </div>
      <div class="stat-info">
        <div class="stat-label">Stok Total</div>
        <div class="stat-value">{{ $totalStock }}</div>
      </div>
    </div>
  </div>
</div>

<!-- Produk Terbaru Section -->
<div class="row mt-4">
  <div class="col-12">
    <div class="content-card">
      <div class="card-header flex-wrap">
        <div class="d-flex justify-content-between align-items-center w-100 gap-3">
          <h5 class="m-0"><i class="fas fa-box me-2" style="color: #bc0007;"></i>Produk Terbaru</h5>
          <a href="{{ route('admin.produk.create') }}" class="btn btn-sm btn-primary ms-auto">
            <i class="fas fa-plus"></i> Tambah Produk
          </a>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-custom mb-0">
          <thead>
            <tr>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Dibuat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentProducts as $p)
              <tr>
                <td>
                  <strong>{{ $p->produk_nama }}</strong>
                </td>
                <td>
                  <span class="badge bg-info">Rp {{ number_format($p->produk_harga, 0, ",", ".") }}</span>
                </td>
                <td>
                  <span class="badge" style="background-color: {{ $p->produk_stok > 5 ? "#43e97b" : "#f5576c" }};">
                    {{ $p->produk_stok }} Unit
                  </span>
                </td>
                <td>
                  <div style="font-size: 0.85rem; white-space: nowrap;" class="text-muted">
                    <i class="far fa-calendar-alt me-1"></i> {{ $p->created_at ? $p->created_at->format("d M Y") : "-" }}
                  </div>
                </td>
                <td>
                  <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('admin.produk.edit', $p->id) }}" class="btn btn-outline-warning" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" onclick="viewProdukDetail('{{ addslashes($p->produk_nama) }}', 'Rp {{ number_format($p->produk_harga, 0, ',', '.') }}', '{{ $p->produk_stok }}', '{{ addslashes(preg_replace('/\r|\n/', ' ', $p->produk_deskripsi ?? '')) }}')" class="btn btn-outline-info" title="Lihat">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-3">
                  <em class="text-muted">Tidak ada produk</em>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Transaksi Terbaru Section -->
<div class="row mt-4">
  <div class="col-12">
    <div class="content-card">
      <div class="card-header flex-wrap">
        <div class="d-flex justify-content-between align-items-center w-100 gap-3">
          <h5 class="m-0"><i class="fas fa-credit-card me-2" style="color: #bc0007;"></i>Transaksi Terbaru</h5>
          <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-primary ms-auto">
            <i class="fas fa-list"></i> Lihat Semua
          </a>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-custom mb-0">
          <thead>
            <tr>
              <th>ID Transaksi</th>
              <th>Pelanggan</th>
              <th>Jumlah</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentTransactions as $t)
              <tr>
                <td>
                  <strong>#{{ $t->id_transaksi ?? $t->id }}</strong>
                </td>
                <td>{{ $t->nama_pelanggan ?? 'Tidak ada nama' }}</td>
                <td>
                  <span class="badge bg-success">Rp {{ number_format($t->total_harga, 0, ",", ".") }}</span>
                </td>
                <td>
                  <div style="font-size: 0.85rem; white-space: nowrap;" class="text-muted">
                    <i class="far fa-calendar-alt me-1"></i> {{ $t->tanggal_transaksi ? \Carbon\Carbon::parse($t->tanggal_transaksi)->format("d M Y H:i") : ($t->created_at ? $t->created_at->format("d M Y H:i") : "-") }}
                  </div>
                </td>
                <td>
                  @if($t->status == 'lunas' || $t->status == 'success' || $t->is_paid)
                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Dibayar</span>
                  @elseif($t->status == 'pending')
                    <span class="badge bg-warning"><i class="fas fa-clock"></i> Pending</span>
                  @else
                    <span class="badge bg-danger"><i class="fas fa-times-circle"></i> {{ ucfirst($t->status) }}</span>
                  @endif
                </td>
                <td>
                  <div class="btn-group btn-group-sm" role="group">
                    <button type="button" onclick="viewTransaksiDetail('{{ $t->id_transaksi ?? $t->id }}', '{{ addslashes($t->nama_pelanggan ?? '') }}', 'Rp {{ number_format($t->total_harga, 0, ',', '.') }}', '{{ $t->tanggal_transaksi ? \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y H:i') : '' }}', '{{ ($t->is_paid || in_array($t->status, ['lunas', 'success'])) ? 'Dibayar' : 'Pending' }}')" class="btn btn-outline-info" title="Lihat">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-3">
                  <em class="text-muted">Tidak ada transaksi</em>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Script -->
<script>
function viewProdukDetail(nama, harga, stok, deskripsi) {
    Swal.fire({
        title: 'Detail Produk',
        html: `
            <div style="text-align: left; padding: 10px; font-size: 0.95rem;">
                <table class="table table-borderless table-sm mb-0">
                    <tr><td width="30%" class="text-muted fw-bold">Nama</td><td><strong class="text-dark">${nama}</strong></td></tr>
                    <tr><td class="text-muted fw-bold">Harga</td><td><strong class="text-danger">${harga}</strong></td></tr>
                    <tr><td class="text-muted fw-bold">Sisa Stok</td><td><strong style="color: #2e7d32;">${stok} Unit</strong></td></tr>
                </table>
                <hr style="opacity: 0.15; margin: 15px 0;">
                <p class="text-muted fw-bold mb-1">Deskripsi:</p>
                <p class="text-dark" style="line-height: 1.5;">${deskripsi || '<em>Tidak ada deskripsi.</em>'}</p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Tutup',
        confirmButtonColor: '#bc0007',
        customClass: {
            popup: 'rounded-4 shadow-lg'
        }
    });
}

function viewTransaksiDetail(id, nama, total, tgl, status) {
    let badge = status === 'Dibayar' 
        ? '<span class="badge bg-success px-3 py-2"><i class="fas fa-check-circle"></i> Lunas</span>' 
        : '<span class="badge bg-warning text-dark px-3 py-2"><i class="fas fa-clock"></i> Pending</span>';
        
    Swal.fire({
        title: 'Pesanan #' + id,
        html: `
            <div style="text-align: left; font-size: 0.95rem; margin-top: 10px;">
                <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                    ${badge}
                    <span class="text-muted fw-bold"><i class="far fa-calendar-alt"></i> ${tgl}</span>
                </div>
                <div class="bg-light p-3 rounded-4 border">
                    <table class="table table-borderless table-sm mb-0">
                        <tr><td width="40%" class="text-muted">Pelanggan</td><td><strong class="text-dark">${nama || '-'}</strong></td></tr>
                        <tr><td class="text-muted">Total Bayar</td><td><strong class="text-danger fs-5">${total}</strong></td></tr>
                    </table>
                </div>
            </div>
        `,
        showConfirmButton: true,
        confirmButtonText: 'Tutup',
        confirmButtonColor: '#bc0007',
        customClass: {
            popup: 'rounded-4 shadow-lg'
        }
    });
}
</script>

@endsection