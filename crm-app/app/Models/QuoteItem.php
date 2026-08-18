<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'description',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (QuoteItem $item) {
            $item->subtotal = round($item->quantity * $item->unit_price, 2);
        });

        static::saved(function (QuoteItem $item) {
            $item->quote?->recalculateTotals();
        });

        static::deleted(function (QuoteItem $item) {
            $item->quote?->recalculateTotals();
        });
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
