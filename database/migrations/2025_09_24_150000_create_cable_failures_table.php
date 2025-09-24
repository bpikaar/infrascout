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
        Schema::create('cable_failures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->enum('type_storing', ['Kabelbreuk','Slechte verbinding','Kortsluiting','Overig']);
            $table->string('locatie_storing')->nullable();
            $table->string('methode_vaststelling')->nullable();
            $table->boolean('kabel_met_aftakking')->default(false);
            $table->text('bijzonderheden')->nullable();
            $table->text('advies')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cable_failures');
    }
};
