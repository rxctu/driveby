<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Order $order, public string $oldStatus) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('admin-orders'),
            new Channel('order.' . $this->order->order_number),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'status' => $this->order->status,
            'old_status' => $this->oldStatus,
            'payment_status' => $this->order->payment_status,
            'updated_at' => $this->order->updated_at->toISOString(),
        ];
    }
}
