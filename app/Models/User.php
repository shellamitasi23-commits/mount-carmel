<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Reservasi;
use App\Models\Pembayaran;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ====================================================
    // RELASI DATABASE (Sesuai Use Case)
    // ====================================================

    /**
     * 1 User (Pembeli) memiliki BANYAK Reservasi
     */
    public function reservasis()
    {
        return $this->hasMany(Reservasi::class);
    }

    /**
     * 1 User (Pembeli) memiliki BANYAK Pembayaran
     */
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}