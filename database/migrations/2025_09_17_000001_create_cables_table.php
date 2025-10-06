<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cables', function (Blueprint $table) {
            $table->id();
            $table->string('cable_type');
            $table->enum('material', ['GPLK', 'XLPE', 'Kunststof']);
            $table->decimal('diameter', 8, 2)->nullable();
            $table->timestamps();
            $table->unique(['cable_type', 'material', 'diameter']);
        });

        Schema::create('cable_report', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cable_id')->constrained('cables')->cascadeOnDelete();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['cable_id', 'report_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cable_report');
        Schema::dropIfExists('cables');
    }
};
