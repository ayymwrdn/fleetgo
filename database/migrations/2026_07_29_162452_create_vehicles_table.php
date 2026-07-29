<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('plate_number')->unique();
            $table->enum('type', ['people', 'goods'])->default('people');
            $table->enum('ownership', ['company', 'rental'])->default('company');
            $table->enum('status', ['available', 'in_use', 'maintenance'])->default('available');
            $table->decimal('fuel_consumption', 5, 2)->nullable();
            $table->date('last_service_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};