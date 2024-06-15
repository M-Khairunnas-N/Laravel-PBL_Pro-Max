<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'level',
        'foto_profil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Define an accessor for the 'foto_profil' attribute
     */
    public function getFotoProfilAttribute(): string
    {
        if ($this->attributes['foto_profil'] === null) {
            return asset('img/default_foto_user.jpeg');
        }

        return asset('user/' . $this->attributes['foto_profil']);
    }

    /**
     * Define an accessor for the 'created_at' attribute
     */
    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    /**
     * Eloquent Model Relationships
     */
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'user_id', 'user_id');
    }
    public function kaders(): HasMany
    {
        return $this->hasMany(Kader::class, 'user_id', 'user_id');
    }
}
