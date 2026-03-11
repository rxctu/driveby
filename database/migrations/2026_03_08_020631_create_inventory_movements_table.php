<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('barcode_mapping_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['in', 'out'])->default('in');
            $table->enum('unit_type', ['unite', 'pack', 'carton', 'palette'])->default('unite');
            $table->integer('unit_count')->default(1);
            $table->integer('quantity_per_unit')->default(1);
            $table->integer('total_quantity');
            $table->string('barcode')->nullable()->index();
            $table->string('note')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
