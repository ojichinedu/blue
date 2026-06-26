<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Shipment extends Model
{
    protected $fillable = [
        'tracking_number',
        'user_id',
        'sender_name',
        'sender_email',
        'sender_phone',
        'sender_address',
        'receiver_name',
        'receiver_email',
        'receiver_phone',
        'receiver_address',
        'package_description',
        'weight',
        'package_type',
        'status',
        'origin_lat',
        'origin_lng',
        'destination_lat',
        'destination_lng',
        'current_lat',
        'current_lng',
        'estimated_delivery',
        'actual_delivery',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'origin_lat' => 'decimal:7',
        'origin_lng' => 'decimal:7',
        'destination_lat' => 'decimal:7',
        'destination_lng' => 'decimal:7',
        'current_lat' => 'decimal:7',
        'current_lng' => 'decimal:7',
        'estimated_delivery' => 'datetime',
        'actual_delivery' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Shipment $shipment) {
            if (empty($shipment->tracking_number)) {
                $shipment->tracking_number = self::generateTrackingNumber();
            }
        });
    }

    public static function generateTrackingNumber(): string
    {
        do {
            $number = 'BLU-' . strtoupper(Str::random(8));
        } while (self::where('tracking_number', $number)->exists());

        return $number;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updates(): HasMany
    {
        return $this->hasMany(ShipmentUpdate::class)->orderBy('update_time', 'asc');
    }

    public function latestUpdate()
    {
        return $this->hasOne(ShipmentUpdate::class)->latestOfMany('update_time');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByTrackingNumber($query, $trackingNumber)
    {
        return $query->where('tracking_number', $trackingNumber);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'picked_up' => 'Picked Up',
            'in_transit' => 'In Transit',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'picked_up' => 'blue',
            'in_transit' => 'indigo',
            'out_for_delivery' => 'orange',
            'delivered' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }
}
