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
        Schema::table('checkouts', function (Blueprint $table) {
            $table->timestamp('redeemed_at')->nullable()->after('paid_at');
            $table->foreignId('redeemed_by')->nullable()->after('redeemed_at')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropForeign(['redeemed_by']);
            $table->dropColumn(['redeemed_at', 'redeemed_by']);
        });
    }
};
