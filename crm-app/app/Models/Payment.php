<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'amount', 'payment_date', 'method', 'status'];

    protected $casts = ['payment_date' => 'date'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}