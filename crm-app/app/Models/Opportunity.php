<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    public const STAGES = [
        1 => 'Nuevo Prospecto',
        2 => 'Diagnóstico',
        3 => 'Presentación',
        4 => 'Propuesta',
        5 => 'Negociación',
        6 => 'Aprobación',
        7 => 'Cobranza',
        8 => 'Cliente Activo',
        9 => 'Renovación',
        10 => 'Referidos',
    ];

    protected $fillable = [
        'lead_id', 'closer_id', 'stage', 'product', 'amount', 'comments',
    ];

    protected $casts = [
        'stage' => \App\Enums\OpportunityStage::class,
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function closer()
    {
        return $this->belongsTo(User::class, 'closer_id');
    }
}
