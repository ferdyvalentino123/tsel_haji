@extends("admin.layout")
@section("title", "Riwayat Stok")
@section("content")

<div class="mb-4">
  <h1 class="page-title"><i class="fas fa-history"></i> Riwayat Perubahan Stok</h1>
  <p class="text-muted">Pantau seluruh aktivitas penambahan dan pengurangan stok produk maupun merchandise.</p>
</div>

<div class="row">
  <div class="col-12">
    <div class="content-card">
      <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2 text-danger"></i>Log Aktivitas Stok</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="bg-light">
            <tr>
              <th style="width: 50px;">No</th>
              <th>Item</th>
              <th>Kategori</th>
              <th>Aksi</th>
              <th>Jumlah</th>
              <th>Stok Awal</th>
              <th>Stok Akhir</th>
              <th>Waktu</th>
            </tr>
          </thead>
          <tbody>
            @forelse($stockHistory as $history)
              <tr>
                <td><strong>{{ ($stockHistory->currentPage() - 1) * $stockHistory->perPage() + $loop->iteration }}</strong></td>
                <td>
                  @if($history->product)
                    <div class="d-flex align-items-center">
                      <div class="icon-circle bg-red-light me-2" style="width: 35px; height: 35px; font-size: 0.8rem;">
                        <i class="fas fa-box text-danger"></i>
                      </div>
                      <div>
                        <div class="fw-bold">{{ $history->product->produk_nama }}</div>
                        <small class="text-muted">ID: {{ $history->product_id }}</small>
                      </div>
                    </div>
                  @elseif($history->merchandise)
                    <div class="d-flex align-items-center">
                      <div class="icon-circle bg-gold-light me-2" style="width: 35px; height: 35px; font-size: 0.8rem;">
                        <i class="fas fa-gift text-warning"></i>
                      </div>
                      <div>
                        <div class="fw-bold">{{ $history->merchandise->merch_nama }}</div>
                        <small class="text-muted">ID: {{ $history->merchandise_id }}</small>
                      </div>
                    </div>
                  @else
                    <span class="text-muted italic">Item dihapus</span>
                  @endif
                </td>
                <td>
                  <span class="badge @if($history->product) bg-primary @else bg-warning text-dark @endif">
                    {{ $history->product ? 'Produk' : 'Merchandise' }}
                  </span>
                </td>
                <td>
                  @php
                    $isAddition = in_array(strtolower($history->action), ['add', 'tambah', 'restock']);
                  @endphp
                  <span class="badge {{ $isAddition ? 'bg-success' : 'bg-danger' }}">
                    <i class="fas {{ $isAddition ? 'fa-plus-circle' : 'fa-minus-circle' }} me-1"></i>
                    {{ ucfirst($history->action) }}
                  </span>
                </td>
                <td class="fw-bold {{ $isAddition ? 'text-success' : 'text-danger' }}">
                  {{ $isAddition ? '+' : '' }}{{ $history->change_amount }}
                </td>
                <td class="text-muted">{{ $history->previous_stock ?? '-' }}</td>
                <td class="fw-bold">{{ $history->current_stock ?? '-' }}</td>
                <td>
                  <div class="small">
                    <div class="fw-bold text-dark">{{ $history->created_at->format('d M Y') }}</div>
                    <div class="text-muted">{{ $history->created_at->format('H:i') }} WIB</div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center py-5">
                  <img src="https://illustrations.popsy.co/red/empty-folder.svg" alt="Empty" style="width: 150px; opacity: 0.5;">
                  <p class="text-muted mt-3">Belum ada riwayat aktivitas stok.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="card-footer bg-white py-3">
        @if($stockHistory->hasPages())
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <small class="text-muted">
              Menampilkan {{ $stockHistory->firstItem() }}–{{ $stockHistory->lastItem() }} dari {{ $stockHistory->total() }} data
            </small>
            <nav>
              <ul class="pagination pagination-sm mb-0" style="gap: 4px; display: flex; align-items: center;">

                {{-- Previous --}}
                @if($stockHistory->onFirstPage())
                  <li class="page-item disabled">
                    <span class="page-link" style="border-radius: 8px; font-size: 0.8rem; padding: 5px 10px;">
                      <i class="fas fa-chevron-left"></i>
                    </span>
                  </li>
                @else
                  <li class="page-item">
                    <a class="page-link" href="{{ $stockHistory->previousPageUrl() }}" style="border-radius: 8px; font-size: 0.8rem; padding: 5px 10px; color: #ec1c24; border-color: #ec1c24;">
                      <i class="fas fa-chevron-left"></i>
                    </a>
                  </li>
                @endif

                {{-- Page Numbers --}}
                @foreach($stockHistory->getUrlRange(max(1, $stockHistory->currentPage() - 2), min($stockHistory->lastPage(), $stockHistory->currentPage() + 2)) as $page => $url)
                  @if($page == $stockHistory->currentPage())
                    <li class="page-item active">
                      <span class="page-link" style="border-radius: 8px; font-size: 0.8rem; padding: 5px 10px; background-color: #ec1c24; border-color: #ec1c24;">{{ $page }}</span>
                    </li>
                  @else
                    <li class="page-item">
                      <a class="page-link" href="{{ $url }}" style="border-radius: 8px; font-size: 0.8rem; padding: 5px 10px; color: #ec1c24; border-color: #dee2e6;">{{ $page }}</a>
                    </li>
                  @endif
                @endforeach

                {{-- Next --}}
                @if($stockHistory->hasMorePages())
                  <li class="page-item">
                    <a class="page-link" href="{{ $stockHistory->nextPageUrl() }}" style="border-radius: 8px; font-size: 0.8rem; padding: 5px 10px; color: #ec1c24; border-color: #ec1c24;">
                      <i class="fas fa-chevron-right"></i>
                    </a>
                  </li>
                @else
                  <li class="page-item disabled">
                    <span class="page-link" style="border-radius: 8px; font-size: 0.8rem; padding: 5px 10px;">
                      <i class="fas fa-chevron-right"></i>
                    </span>
                  </li>
                @endif

              </ul>
            </nav>
          </div>
        @else
          <small class="text-muted">Menampilkan {{ $stockHistory->total() }} data</small>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
