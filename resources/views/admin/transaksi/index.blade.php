@extends("admin.layout")
@section("title", "Daftar Transaksi")
@section("content")

<!-- Page Title -->
<div class="mb-4">
  <h1 class="page-title"><i class="fas fa-credit-card"></i> Daftar Transaksi</h1>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
  <div class="col-lg-4 col-md-6">
    <div class="stat-card">
      <div class="stat-icon stat-icon-2">
        <i class="fas fa-receipt"></i>
      </div>
      <div class="stat-label">Total Transaksi</div>
      <div class="stat-value">{{ \App\Models\Transaksi::count() }}</div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="stat-card">
      <div class="stat-icon stat-icon-3">
        <i class="fas fa-dollar-sign"></i>
      </div>
      <div class="stat-label">Total Pendapatan</div>
      <div class="stat-value">Rp {{ number_format(\App\Models\Transaksi::where('is_paid', 1)->orWhereIn('status', ['lunas', 'success'])->sum("total_harga"), 0, ",", ".") }}</div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="stat-card">
      <div class="stat-icon stat-icon-1">
        <i class="fas fa-check-circle"></i>
      </div>
      <div class="stat-label">Sudah Dibayar</div>
      <div class="stat-value">{{ \App\Models\Transaksi::where("is_paid", 1)->count() }}</div>
    </div>
  </div>
</div>

<!-- Transactions Table -->
<div class="row">
  <div class="col-12">
    <div class="content-card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h5><i class="fas fa-list me-2" style="color: #bc0007;"></i>Daftar Semua Transaksi</h5>
          <form method="GET" class="d-flex gap-2" style="flex: 1; margin-left: 20px; max-width: 300px;">
            <input type="date" name="date" class="form-control" value="{{ request("date") }}">
            <button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Transaksi</th>
              <th>Pelanggan</th>
              <th>Jumlah</th>
              <th>Tanggal</th>
              <th>Status Bayar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($transaksi ?? \App\Models\Transaksi::latest()->paginate(20) as $t)
              <tr>
                <td><strong>{{ $loop->iteration }}</strong></td>
                <td>#{{ $t->id_transaksi }}</td>
                <td>{{ $t->nama_pelanggan }}</td>
                <td>
                  <span class="badge bg-success">Rp {{ number_format($t->total_harga, 0, ",", ".") }}</span>
                </td>
                <td>{{ $t->tanggal_transaksi ? \Carbon\Carbon::parse($t->tanggal_transaksi)->format("d M Y H:i") : "-" }}</td>
                <td>
                  @if($t->is_paid)
                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Dibayar</span>
                  @else
                    <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Pending</span>
                  @endif
                </td>
                <td>
                  <div class="btn-group btn-group-sm" role="group">
                    <button type="button" onclick="viewTransaksiDetail('{{ $t->id_transaksi ?? $t->id }}', '{{ addslashes($t->nama_pelanggan ?? '') }}', 'Rp {{ number_format($t->total_harga, 0, ',', '.') }}', '{{ $t->tanggal_transaksi ? \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y H:i') : '' }}', '{{ ($t->is_paid || in_array($t->status, ['lunas', 'success'])) ? 'Dibayar' : 'Pending' }}')" class="btn btn-outline-info" title="Detail">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4">
                  <em class="text-muted"><i class="fas fa-inbox"></i> Tidak ada transaksi</em>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
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
