<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'shipment_id',
        'receipt_number',
        'amount',
        'payment_method',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Receipt $receipt) {
            if (empty($receipt->receipt_number)) {
                $receipt->receipt_number = self::generateReceiptNumber();
            }
        });
    }

    public static function generateReceiptNumber(): string
    {
        do {
            $number = 'BOL-REC-' . \Illuminate\Support\Str::random(8);
        } while (self::where('receipt_number', $number)->exists());

        return strtoupper($number);
    }

    public function shipment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
