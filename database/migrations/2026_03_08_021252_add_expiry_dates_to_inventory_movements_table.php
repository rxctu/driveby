<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            $table->date('dlc')->nullable()->after('note');
            $table->date('dluo')->nullable()->after('dlc');
            $table->string('lot_number')->nullable()->after('dluo');
        });
    }

    public function down(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            $table->dropColumn(['dlc', 'dluo', 'lot_number']);
        });
    }
};
