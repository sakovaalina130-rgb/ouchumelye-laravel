<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterClass extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['craft_type_id', 'master_id', 'title', 'description', 'date', 'time_slot', 'max_participants', 'price'];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
    ];

    public function craftType()
    {
        return $this->belongsTo(CraftType::class);
    }

    public function master()
    {
        return $this->belongsTo(User::class, 'master_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function getFreeSpotsAttribute(): int
    {
        return $this->max_participants - $this->registrations()->count();
    }
}
