<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Gunakan id sebagai primary key untuk transaksi pelanggan
    // id_transaksi tetap ada untuk kompatibilitas dengan sistem lama
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'history_setoran' => 'array',
    ];
    protected $dates = ['tanggal_transaksi', 'created_at', 'updated_at'];

    protected $fillable = [
        'id_transaksi',
        'nama_pelanggan',
        'nomor_telepon',
        'nomor_injeksi',
        'nomor_roaming',
        'aktivasi_tanggal',
        'tanggal_transaksi',
        'nama_sales',
        'jenis_paket',
        'merchandise',
        'metode_pembayaran',
        'history_setoran',
        'is_setor',
        'is_paid',
        'telepon_pelanggan',
        'addon_perdana',
        'id_supervisor',
        'bertugas', // Menambahkan kolom bertugas
        'tempat_tugas', // Menambahkan kolom tempat_tugas
        'is_activated',
        'id_pelanggan', // Field untuk pelanggan
        'produk_id', // Field untuk produk
        'jumlah', // Field untuk jumlah pembelian
        'total_harga', // Field untuk total harga
        'status', // Field untuk status transaksi
        'snap_token', // Field untuk menyimpan Snap token
    ];

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    // Relasi ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(RoleUsers::class, 'id_pelanggan');
    }

    // Relasi ke Merchandise
    public function merchandises()
    {
        return $this->belongsToMany(Merchandise::class, 'transaksi_merchandise', 'transaksi_id', 'merchandise_id');
    }

    // Akses sejarah setoran
    public function getHistorySetoranAttribute()
    {
        return json_decode($this->attributes['history_setoran'], true) ?? [];
    }

    // Relasi ke RoleUsers (Supervisor)
    public function kasir()
    {
        return $this->belongsTo(RoleUsers::class, 'id_supervisor');
    }

    // Relasi ke RoleUsers untuk mendapatkan data bertugas dan tempat_tugas
    public function roleUser()
    {
        return $this->belongsTo(RoleUsers::class, 'id_supervisor');
    }

    // Menambahkan fungsi untuk mendapatkan bertugas dan tempat_tugas dari RoleUsers
    public function setBertugasFromRoleUser()
    {
        if ($this->roleUser) {
            $this->bertugas = $this->roleUser->bertugas ?? 0; // default 0 jika tidak ada nilai
            $this->tempat_tugas = $this->roleUser->tempat_tugas;
            $this->save();
        }
    }
    
    public function sales()
    {
        return $this->belongsTo(RoleUsers::class, 'nama_sales', 'name');
    }
}

