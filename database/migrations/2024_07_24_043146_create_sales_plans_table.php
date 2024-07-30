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
        Schema::create('SalesPlans', function (Blueprint $table) {
            $table->id();
            $table->string('part_number_assy');
            $table->string('part_number_customer');
            $table->string('part_name_customer');
            $table->string('product');
            $table->integer('qty_fy24');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SalesPlans');
    }
};
