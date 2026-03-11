<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barcode_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique()->index();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->enum('unit_type', ['unite', 'pack', 'carton', 'palette'])->default('unite');
            $table->integer('quantity_per_unit')->default(1);
            $table->string('supplier_ref')->nullable();
            $table->string('label')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barcode_mappings');
    }
};
