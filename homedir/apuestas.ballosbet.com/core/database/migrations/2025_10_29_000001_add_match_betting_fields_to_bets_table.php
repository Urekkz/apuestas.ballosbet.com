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
        Schema::table('bets', function (Blueprint $table) {
            $table->boolean('is_open')->default(false)->after('is_settled')->comment('Si la apuesta está disponible para ser tapada');
            $table->unsignedBigInteger('matched_bet_id')->nullable()->after('is_open')->comment('ID de la apuesta que tapó esta apuesta');
            $table->unsignedBigInteger('matched_by_user_id')->nullable()->after('matched_bet_id')->comment('ID del usuario que tapó esta apuesta');
            $table->timestamp('matched_at')->nullable()->after('matched_by_user_id')->comment('Fecha cuando fue tapada');
            
            $table->foreign('matched_bet_id')->references('id')->on('bets')->onDelete('set null');
            $table->foreign('matched_by_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bets', function (Blueprint $table) {
            $table->dropForeign(['matched_bet_id']);
            $table->dropForeign(['matched_by_user_id']);
            $table->dropColumn(['is_open', 'matched_bet_id', 'matched_by_user_id', 'matched_at']);
        });
    }
};
