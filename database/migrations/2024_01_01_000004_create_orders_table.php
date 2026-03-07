<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique();
            $table->enum('status', [
                'pending',
                'confirmed',
                'preparing',
                'delivering',
                'delivered',
                'cancelled',
            ])->default('pending');
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->text('customer_address');
            $table->text('delivery_instructions')->nullable();
            $table->decimal('delivery_fee', 8, 2)->default(0);
            $table->decimal('subtotal', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('delivery_slot')->nullable();
            $table->date('delivery_date')->nullable();
            $table->enum('payment_method', ['cash', 'stripe', 'paypal'])->default('cash');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('stripe_payment_id')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('payment_status');
            $table->index('delivery_date');
            $table->index(['status', 'delivery_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
