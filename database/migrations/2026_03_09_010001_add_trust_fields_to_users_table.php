<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('trust_level')->default(0)->after('is_admin');
            $table->boolean('is_verified')->default(false)->after('trust_level');
            $table->text('admin_notes')->nullable()->after('is_verified');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['trust_level', 'is_verified', 'admin_notes']);
        });
    }
};
