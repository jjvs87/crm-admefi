<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id', 'has_company', 'employees', 'has_inhouse_lawyer',
        'has_insurance', 'has_lawsuits', 'has_overdue_debt', 'has_branches',
        'decision_maker', 'revenue', 'level',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}