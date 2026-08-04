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

    protected static function booted(): void
    {
        static::creating(function (Lead $lead) {
            if (empty($lead->hunter_id)) {
                $hunter = User::where('role', 'hunter')
                    ->where('active', true)
                    ->withCount('leads')
                    ->orderBy('leads_count')
                    ->first();

                if ($hunter) {
                    $lead->hunter_id = $hunter->id;
                }
            }
        });
    }

    public function hunter()
    {
        return $this->belongsTo(User::class, 'hunter_id');
    }

    public function qualification()
    {
        return $this->hasOne(Qualification::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}