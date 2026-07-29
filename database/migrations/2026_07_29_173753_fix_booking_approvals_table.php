<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('booking_approvals', function (Blueprint $table) {
            // Cek apakah kolom booking_id sudah ada
            if (!Schema::hasColumn('booking_approvals', 'booking_id')) {
                $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('booking_approvals', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropColumn('booking_id');
        });
    }
};