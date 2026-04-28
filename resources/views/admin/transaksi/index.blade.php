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
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 w-100">
          <h5 class="mb-0"><i class="fas fa-list me-2" style="color: #bc0007;"></i>Daftar Semua Transaksi</h5>
          <div class="d-flex gap-2 flex-wrap align-items-center">
            {{-- Filter tanggal --}}
            <form method="GET" class="d-flex gap-2" id="filterForm">
              <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
              <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-filter me-1"></i>Filter
              </button>
              @if(request('date'))
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset filter">
                  <i class="fas fa-times"></i>
                </a>
              @endif
            </form>
            {{-- Tombol Export Excel — meneruskan filter tanggal yang sedang aktif --}}
            <a href="{{ route('admin.transaksi.export', request()->only('date')) }}"
               class="btn btn-sm btn-success d-flex align-items-center gap-1"
               title="{{ request('date') ? 'Export data ' . request('date') : 'Export semua transaksi' }}">
              <i class="fas fa-file-excel"></i>
              <span>Export Excel</span>
              @if(request('date'))
                <span class="badge bg-white text-success ms-1" style="font-size:0.65rem;">
                  {{ \Carbon\Carbon::parse(request('date'))->translatedFormat('d M Y') }}
                </span>
              @endif
            </a>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Transaksi</th>
              <th>Pelanggan</th>
              <th>No. Roaming</th>
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
                {{-- Kolom No. Roaming: ditampilkan badge jika kosong, tombol edit selalu ada --}}
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <span id="roaming-display-{{ $t->id }}"
                          class="roaming-value {{ $t->nomor_roaming ? 'text-dark fw-semibold' : 'text-muted fst-italic' }}">
                      {{ $t->nomor_roaming ?: '-' }}
                    </span>
                    @if(!$t->nomor_roaming)
                      <span class="badge bg-secondary" style="font-size:0.65rem;">Belum diisi</span>
                    @endif
                    <button type="button"
                            class="btn btn-link btn-sm p-0 ms-1 text-primary"
                            title="Edit No. Roaming"
                            onclick="openRoamingModal({{ $t->id }}, '{{ addslashes($t->nomor_roaming ?? '') }}', '{{ $t->id_transaksi }}')"
                            style="line-height:1;">
                      <i class="fas fa-pencil-alt" style="font-size:0.75rem;"></i>
                    </button>
                  </div>
                </td>
                <td>
                  <span class="badge bg-success">Rp {{ number_format($t->total_harga, 0, ",", ".") }}</span>
                </td>
                <td>{{ $t->tanggal_transaksi ? \Carbon\Carbon::parse($t->tanggal_transaksi)->format("d M Y H:i") : "-" }}</td>
                <td>
                  @if($t->status == 'lunas' || $t->status == 'success' || $t->is_paid)
                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Lunas</span>
                  @elseif($t->status == 'pending' || !$t->status)
                    <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Pending </span>
                  @else
                    <span class="badge bg-danger"><i class="fas fa-times-circle"></i> {{ ucfirst($t->status) }}</span>
                  @endif
                </td>
                <td>
                  <div class="btn-group btn-group-sm" role="group">
                    <button type="button" onclick="viewTransaksiDetail('{{ $t->id_transaksi ?? $t->id }}', '{{ addslashes($t->nama_pelanggan ?? '') }}', 'Rp {{ number_format($t->total_harga, 0, ',', '.') }}', '{{ $t->tanggal_transaksi ? \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y H:i') : '' }}', '{{ ($t->is_paid || in_array($t->status, ['lunas', 'success'])) ? 'Dibayar' : 'Pending' }}', '{{ addslashes($t->nomor_roaming ?? '') }}')" class="btn btn-outline-info" title="Detail">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center py-4">
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
function viewTransaksiDetail(id, nama, total, tgl, status, roaming) {
    let badge = status === 'Dibayar' 
        ? '<span class="badge bg-success px-3 py-2"><i class="fas fa-check-circle"></i> Lunas</span>' 
        : '<span class="badge bg-warning text-dark px-3 py-2"><i class="fas fa-clock"></i> Pending</span>';

    let roamingDisplay = roaming
        ? `<strong class="text-dark">${roaming}</strong>`
        : `<span class="text-muted fst-italic">Belum diisi</span>`;
        
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
                        <tr><td class="text-muted">No. Roaming</td><td>${roamingDisplay}</td></tr>
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

{{-- ═══════════════════════════════════════════════════════════
     Modal Edit No. Roaming
     Diisi manual oleh tim internal — data API Telkomsel belum tersedia
     ═══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="roamingModal" tabindex="-1" aria-labelledby="roamingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header border-0" style="background: linear-gradient(135deg,#bc0007,#e2241d); color:#fff;">
        <h5 class="modal-title fw-bold" id="roamingModalLabel">
          <i class="fas fa-sim-card me-2"></i>Edit No. Roaming
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body px-4 py-4">
        <div class="alert alert-light border d-flex align-items-start gap-2 py-2 px-3 mb-3" style="font-size:0.82rem;">
          <i class="fas fa-info-circle text-primary mt-1 flex-shrink-0"></i>
          <span>Nomor roaming diisi secara <strong>manual oleh tim internal</strong>. Kosongkan untuk menghapus nomor roaming yang sudah tersimpan.</span>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold text-muted small text-uppercase" for="roamingIdTransaksiDisplay">
            <i class="fas fa-receipt me-1"></i>ID Transaksi
          </label>
          <input type="text" id="roamingIdTransaksiDisplay" class="form-control bg-light" readonly>
        </div>
        <div class="mb-1">
          <label class="form-label fw-semibold text-muted small text-uppercase" for="roamingNomor">
            <i class="fas fa-sim-card me-1"></i>Nomor Roaming
          </label>
          <input type="text" id="roamingNomor" class="form-control"
                 placeholder="Contoh: +628123456789"
                 maxlength="20"
                 autocomplete="off">
          <div id="roamingError" class="invalid-feedback"></div>
        </div>
        <p class="text-muted mb-0" style="font-size:0.72rem; margin-top:4px;">
          Maksimal 20 karakter. Hanya angka, +, -, atau spasi.
        </p>
      </div>
      <div class="modal-footer border-0 px-4 pb-4 gap-2">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i>Batal
        </button>
        <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold" id="roamingSaveBtn"
                onclick="saveRoaming()">
          <i class="fas fa-save me-1"></i>Simpan
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// ID primary key transaksi yang sedang diedit
let _roamingTargetId = null;

/**
 * Buka modal edit No. Roaming.
 * @param {number} transaksiId  - primary key (id) baris transaksi
 * @param {string} currentValue - nilai nomor_roaming saat ini (bisa '')
 * @param {string} idTransaksi  - id_transaksi (untuk ditampilkan ke user)
 */
function openRoamingModal(transaksiId, currentValue, idTransaksi) {
    _roamingTargetId = transaksiId;
    document.getElementById('roamingIdTransaksiDisplay').value = '#' + idTransaksi;
    document.getElementById('roamingNomor').value = currentValue || '';
    // Reset state error
    const nomInput = document.getElementById('roamingNomor');
    nomInput.classList.remove('is-invalid');
    document.getElementById('roamingError').textContent = '';
    new bootstrap.Modal(document.getElementById('roamingModal')).show();
}

/**
 * Kirim PATCH request untuk menyimpan / menghapus nomor roaming.
 * Update tampilan tabel secara inline tanpa reload halaman.
 */
function saveRoaming() {
    if (!_roamingTargetId) return;

    const nomor   = document.getElementById('roamingNomor').value.trim();
    const saveBtn = document.getElementById('roamingSaveBtn');
    const nomInput = document.getElementById('roamingNomor');

    // Reset error
    nomInput.classList.remove('is-invalid');
    document.getElementById('roamingError').textContent = '';

    saveBtn.disabled = true;
    saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';

    fetch(`{{ url('/programhaji/admin/transaksi') }}/${_roamingTargetId}/roaming`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ nomor_roaming: nomor || null })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // ── Update tampilan kolom inline ──────────────────────────
            const display = document.getElementById('roaming-display-' + _roamingTargetId);
            if (display) {
                if (data.nomor_roaming) {
                    display.textContent = data.nomor_roaming;
                    display.className = 'roaming-value text-dark fw-semibold';
                    // Hapus badge "Belum diisi" jika ada
                    const nextEl = display.nextElementSibling;
                    if (nextEl && nextEl.classList.contains('badge')) nextEl.remove();
                } else {
                    display.textContent = '-';
                    display.className = 'roaming-value text-muted fst-italic';
                }
            }
            // ── Tutup modal & tampilkan notifikasi sukses ─────────────
            bootstrap.Modal.getInstance(document.getElementById('roamingModal')).hide();
            Swal.fire({
                icon: 'success',
                title: 'Tersimpan!',
                text: 'Nomor roaming berhasil diperbarui.',
                timer: 2000,
                showConfirmButton: false,
            });
        } else {
            // Tampilkan error validasi dari server
            nomInput.classList.add('is-invalid');
            document.getElementById('roamingError').textContent =
                data.message || 'Terjadi kesalahan. Periksa kembali input Anda.';
        }
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal Terhubung',
            text: 'Tidak dapat terhubung ke server. Periksa koneksi Anda dan coba lagi.',
        });
    })
    .finally(() => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = '<i class="fas fa-save me-1"></i>Simpan';
    });
}
</script>

@endsection
