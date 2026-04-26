@extends("admin.layout")
@section("title", "Manajemen Pengguna")
@section("content")

<div class="mb-4 d-flex justify-content-between align-items-center">
  <h1 class="page-title mb-0"><i class="fas fa-users"></i> Manajemen Pengguna</h1>
  <a href="/programhaji/admin/users/create" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Pengguna
  </a>
</div>

<div class="row">
  <div class="col-12">
    <div class="content-card">
      <div class="card-header">
        <h5><i class="fas fa-list me-2" style="color: #bc0007;"></i>Daftar Pengguna</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse(\App\Models\RoleUsers::paginate(15) as $user)
              <tr>
                <td><strong>{{ $loop->iteration }}</strong></td>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                <td><span class="badge bg-primary">{{ ucfirst($user->role) }}</span></td>
                <td><span class="badge bg-success">Aktif</span></td>
                <td>
                  <a href="/programhaji/admin/users/{{ $user->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center py-3">Belum ada pengguna</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
