<?php

namespace App\Models;
use App\Models\Lending;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'password_changed',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password_changed' => 'boolean',
    ];
    
    public function lendings()
    {
        return $this->hasMany(Lending::class);
    }
}