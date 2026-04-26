<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Produk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'produk_nama', 'produk_harga', 'produk_diskon', 'produk_stok',
        'produk_detail', 'produk_insentif', 'produk_terjual_history'
    ];


    public function merchandises()
    {
        return $this->belongsToMany(Merchandise::class, 'merchandise_produk');
    }
    protected $casts = [
        'produk_terjual_history' => 'array',
    ];

}
