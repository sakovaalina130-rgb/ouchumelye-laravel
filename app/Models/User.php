<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['fio', 'email', 'password', 'phone', 'role', 'photo'];
    protected $hidden = ['password', 'remember_token'];

    public function isMaster(): bool
    {
        return $this->role === 2;
    }

    public function masterClasses()
    {
        return $this->hasMany(MasterClass::class, 'master_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
