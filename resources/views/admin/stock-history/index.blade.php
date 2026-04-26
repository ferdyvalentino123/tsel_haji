@extends("admin.layout")
@section("title", "Riwayat Stok")
@section("content")

<div class="mb-4">
  <h1 class="page-title"><i class="fas fa-history"></i> Riwayat Stok</h1>
</div>

<div class="row">
  <div class="col-12">
    <div class="content-card">
      <div class="card-header">
        <h5><i class="fas fa-list me-2" style="color: #bc0007;"></i>Daftar Perubahan Stok</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>Produk</th>
              <th>Tipe</th>
              <th>Jumlah</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @forelse(\App\Models\StockHistory::latest()->paginate(20) as $history)
              <tr>
                <td><strong>{{ $loop->iteration }}</strong></td>
                <td>{{ $history->produk->produk_nama ?? "-" }}</td>
                <td><span class="badge bg-info">{{ $history->tipe ?? "-" }}</span></td>
                <td>{{ $history->jumlah }}</td>
                <td>{{ $history->created_at->format("d M Y H:i") }}</td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center py-3">Belum ada riwayat stok</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
