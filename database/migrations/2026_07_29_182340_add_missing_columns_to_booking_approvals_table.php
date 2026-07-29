<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('booking_approvals', function (Blueprint $table) {
            // Cek dan tambahkan kolom approver_id
            if (!Schema::hasColumn('booking_approvals', 'approver_id')) {
                $table->foreignId('approver_id')->constrained('users')->onDelete('cascade')->after('booking_id');
            }
            
            // Cek dan tambahkan kolom level
            if (!Schema::hasColumn('booking_approvals', 'level')) {
                $table->tinyInteger('level')->comment('1 or 2')->after('approver_id');
            }
            
            // Cek dan tambahkan kolom status
            if (!Schema::hasColumn('booking_approvals', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('level');
            }
            
            // Cek dan tambahkan kolom note
            if (!Schema::hasColumn('booking_approvals', 'note')) {
                $table->text('note')->nullable()->after('status');
            }
            
            // Cek dan tambahkan kolom approved_at
            if (!Schema::hasColumn('booking_approvals', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('note');
            }
        });
    }

    public function down()
    {
        Schema::table('booking_approvals', function (Blueprint $table) {
            $table->dropForeign(['approver_id']);
            $table->dropColumn([
                'approver_id',
                'level',
                'status',
                'note',
                'approved_at'
            ]);
        });
    }
};