<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_number',
        'opportunity_id',
        'lead_id',
        'client_id',
        'user_id',
        'status',
        'valid_until',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'total',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'valid_until' => 'date',
            'subtotal' => 'decimal:2',
            'tax_rate' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Quote $quote) {
            if (empty($quote->quote_number)) {
                $last = static::orderByDesc('id')->first();
                $next = $last ? $last->id + 1 : 1;
                $quote->quote_number = 'COT-'.str_pad($next, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function recalculateTotals(): void
    {
        $subtotal = $this->items()->sum('subtotal');
        $taxAmount = round($subtotal * ($this->tax_rate / 100), 2);

        $this->subtotal = $subtotal;
        $this->tax_amount = $taxAmount;
        $this->total = $subtotal + $taxAmount;
        $this->saveQuietly();
    }
}
