<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gps_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->enum('gemeten_met', ['Veldboek 1','Veldboek 2']);
            $table->boolean('data_verstuurd_naar_tekenaar')->default(false);
            $table->enum('signaal', ['Slecht','Matig','Goed']);
            $table->enum('omgeving', ['Open veld','Tussen bebouwing','Bosrijk gebied']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gps_measurements');
    }
};
