<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pipes', function (Blueprint $table) {
            $table->id();
            $table->string('pipe_type');
            $table->string('material')->nullable();
            $table->decimal('diameter',8,2)->nullable();
            $table->timestamps();
        });

        Schema::create('pipe_report', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pipe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('report_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['pipe_id','report_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pipe_report');
        Schema::dropIfExists('pipes');
    }
};
