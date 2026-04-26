@extends("admin.layout")
@section("title", "Manajemen Merchandise")
@section("content")

<div class="mb-4 d-flex justify-content-between align-items-center">
  <h1 class="page-title mb-0"><i class="fas fa-gift"></i> Manajemen Merchandise</h1>
  <a href="/programhaji/admin/merchandise/create" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Merchandise
  </a>
</div>

<div class="row">
  <div class="col-12">
    <div class="content-card">
      <div class="card-header">
        <h5><i class="fas fa-list me-2" style="color: #bc0007;"></i>Daftar Merchandise</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse(\App\Models\Merchandise::paginate(15) as $item)
              <tr>
                <td><strong>{{ $loop->iteration }}</strong></td>
                <td><strong>{{ $item->merchandise_nama }}</strong></td>
                <td><span class="badge bg-info">Rp {{ number_format($item->merchandise_harga ?? 0, 0, ",", ".") }}</span></td>
                <td><span class="badge bg-success">{{ $item->merchandise_stok ?? 0 }}</span></td>
                <td>
                  <a href="/programhaji/admin/merchandise/{{ $item->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center py-3">Belum ada merchandise</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
