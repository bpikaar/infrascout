<?php

use App\Models\Report;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ground_radars', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Report::class)->constrained()->cascadeOnDelete();

            $table->decimal('ingestelde_detectiediepte', 8, 2)->nullable();

            $table->enum('radarbeeld', ['Slecht','Matig','Goed','Zeer Goed'])->nullable(); //

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ground_radars');
    }
};
