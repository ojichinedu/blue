<?php

namespace App\Events;

use App\Models\Shipment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShipmentPositionUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $shipment;

    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('shipment.' . $this->shipment->tracking_number),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'tracking_number' => $this->shipment->tracking_number,
            'status' => $this->shipment->status,
            'status_label' => $this->shipment->status_label,
            'current_lat' => (float) $this->shipment->current_lat,
            'current_lng' => (float) $this->shipment->current_lng,
        ];
    }
}
