<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;


class RoleUsers extends Authenticatable
{
    use HasFactory;
    use HasRoles;

    protected $table = 'role_users';

    protected $fillable = [
        'name',
        'email',
        'photo',
        'pin',
        'role',
        'phone',
        'is_superuser',
        'is_setoran',
        'bertugas',
        'tempat_tugas',
    ];

    /**
     * Hash the PIN before saving to the database.
     *
     * @param string $value
     */
    public function setPinAttribute($value)
    {
        $this->attributes['pin'] = bcrypt($value);
    }

    /**
     *
     * @return bool
     */
    // public function isSuperUser(): bool
    // {
    //     return $this->role === 'kasir' && $this->is_superuser;
    // }

    // In your RoleUsers model or User model
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
