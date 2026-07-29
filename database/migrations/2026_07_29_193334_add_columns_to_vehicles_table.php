<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Cek apakah kolom sudah ada sebelum menambah
            if (!Schema::hasColumn('vehicles', 'brand')) {
                $table->string('brand')->nullable()->after('name');
            }
            if (!Schema::hasColumn('vehicles', 'year')) {
                $table->integer('year')->nullable()->after('plate_number');
            }
            if (!Schema::hasColumn('vehicles', 'capacity')) {
                $table->integer('capacity')->nullable()->after('type');
            }
            if (!Schema::hasColumn('vehicles', 'odometer')) {
                $table->integer('odometer')->nullable()->after('fuel_consumption');
            }
            if (!Schema::hasColumn('vehicles', 'next_service_date')) {
                $table->date('next_service_date')->nullable()->after('last_service_date');
            }
            if (!Schema::hasColumn('vehicles', 'insurance_expiry')) {
                $table->date('insurance_expiry')->nullable()->after('status');
            }
        });
    }

    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'brand',
                'year',
                'capacity',
                'odometer',
                'next_service_date',
                'insurance_expiry'
            ]);
        });
    }
};