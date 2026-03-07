<?php

namespace Tests\Unit;

use App\Models\Order;
use PHPUnit\Framework\TestCase;

class OrderModelTest extends TestCase
{
    public function test_order_casts_include_encrypted_fields(): void
    {
        $order = new Order;
        $casts = $order->getCasts();

        $this->assertEquals('encrypted', $casts['customer_name']);
        $this->assertEquals('encrypted', $casts['customer_phone']);
        $this->assertEquals('encrypted', $casts['customer_address']);
        $this->assertEquals('encrypted', $casts['delivery_instructions']);
    }

    public function test_order_fillable_does_not_include_id(): void
    {
        $order = new Order;
        $this->assertNotContains('id', $order->getFillable());
    }
}
