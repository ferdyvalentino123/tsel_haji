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
              <th style="width: 50px;">No</th>
              <th>Nama Merchandise</th>
              <th>Detail</th>
              <th>Stok</th>
              <th style="width: 150px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($merchandise as $item)
              <tr>
                <td><strong>{{ ($merchandise->currentPage() - 1) * $merchandise->perPage() + $loop->iteration }}</strong></td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="icon-circle bg-light me-3">
                      <i class="fas fa-gift text-danger"></i>
                    </div>
                    <strong>{{ $item->merch_nama }}</strong>
                  </div>
                </td>
                <td><small class="text-muted">{{ \Illuminate\Support\Str::limit($item->merch_detail, 50) }}</small></td>
                <td>
                  <span class="badge @if($item->merch_stok > 10) bg-success @else bg-warning @endif">
                    {{ $item->merch_stok }} Unit
                  </span>
                </td>
                <td>
                  <div class="btn-group">
                    <a href="{{ route('admin.merchandise.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.merchandise.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus merchandise ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center py-5">
                <img src="https://illustrations.popsy.co/red/empty-folder.svg" alt="Empty" style="width: 150px; opacity: 0.5;">
                <p class="text-muted mt-3">Belum ada data merchandise.</p>
              </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="card-footer bg-white">
        {{ $merchandise->links() }}
      </div>
    </div>
  </div>
</div>

@endsection
