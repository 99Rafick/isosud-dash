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
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->string('operator');
            $table->string('target_type');
            $table->string('number_target')->nullable();
            $table->string('date_target')->nullable();
            $table->foreignIdFor(\App\Models\IndicatorFrequency::class)->constrained();
            $table->foreignIdFor(\App\Models\Process::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
