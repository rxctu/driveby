<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Widen PII columns to TEXT to accommodate encrypted values (RGPD compliance).
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('customer_name')->change();
            $table->text('customer_phone')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->text('phone')->nullable()->change();
            $table->text('address')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->change();
            $table->string('customer_phone', 20)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->change();
            $table->string('address', 500)->nullable()->change();
        });
    }
};
