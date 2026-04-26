@extends("admin.layout")
@section("title", "Manajemen Produk")
@section("content")

<!-- Page Title -->
<div class="mb-4 d-flex justify-content-between align-items-center">
  <h1 class="page-title mb-0"><i class="fas fa-box"></i> Manajemen Produk</h1>
  <a href="/programhaji/admin/produk/create" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Produk Baru
  </a>
</div>

<!-- Search & Filter -->
<div class="row mb-4">
  <div class="col-12">
    <form method="GET" class="d-flex gap-2">
      <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request("search") }}">
      <button type="submit" class="btn btn-outline-primary">
        <i class="fas fa-search"></i> Cari
      </button>
    </form>
  </div>
</div>

<!-- Products Table -->
<div class="row">
  <div class="col-12">
    <div class="content-card">
      <div class="card-header">
        <h5><i class="fas fa-list me-2" style="color: #bc0007;"></i>Daftar Produk</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Kategori</th>
              <th>Dibuat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($produk ?? \App\Models\Produk::paginate(10) as $item)
              <tr>
                <td><strong>{{ $loop->iteration }}</strong></td>
                <td>
                  <strong>{{ $item->produk_nama }}</strong>
                  <br>
                  <small class="text-muted">{{ Str::limit($item->produk_deskripsi ?? "-", 40) }}</small>
                </td>
                <td>
                  <span class="badge bg-info">Rp {{ number_format($item->produk_harga, 0, ",", ".") }}</span>
                </td>
                <td>
                  <span class="badge" style="background-color: {{ $item->produk_stok > 5 ? "#43e97b" : ($item->produk_stok > 0 ? "#ffc107" : "#f5576c") }};">
                    {{ $item->produk_stok }}
                  </span>
                </td>
                <td>{{ $item->produk_kategori ?? "-" }}</td>
                <td>{{ $item->created_at?->format("d M Y") ?? "-" }}</td>
                <td>
                  <div class="btn-group btn-group-sm" role="group">
                    <a href="/programhaji/admin/produk/{{ $item->id }}/edit" class="btn btn-outline-warning" title="Edit">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                    <button onclick="deleteProduk({{ $item->id }})" class="btn btn-outline-danger" title="Hapus">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4">
                  <em class="text-muted"><i class="fas fa-inbox"></i> Belum ada produk</em>
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
function deleteProduk(id) {
  if (confirm("Yakin ingin menghapus produk ini?")) {
    fetch(`/programhaji/admin/produk/${id}`, {
      method: "DELETE",
      headers: {
        "X-CSRF-TOKEN": document.querySelector("meta[name=\"csrf-token\"]")?.content,
        "Accept": "application/json"
      }
    }).then(r => r.json()).then(d => {
      if (d.success) location.reload();
      else alert("Gagal menghapus");
    });
  }
}
</script>

@endsection
