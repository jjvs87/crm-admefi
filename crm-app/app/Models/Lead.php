<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'company', 'industry', 'position', 'phone', 'whatsapp',
        'email', 'city', 'state', 'employees', 'revenue', 'source',
        'status', 'hunter_id',
    ];

    public function hunter()
    {
        return $this->belongsTo(User::class, 'hunter_id');
    }

    public function qualification()
    {
        return $this->hasOne(Qualification::class);
    }
}