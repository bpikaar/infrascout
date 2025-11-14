<?php

use App\Models\Report;
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
        Schema::create('radio_detections', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Report::class)->constrained()->cascadeOnDelete();

            $table->text('signaal_op_kabel');

            $table->string('signaal_sterkte');
            $table->string('frequentie');
            $table->enum('aansluiting', ['Passief', 'Actief']);
            $table->enum('zender_type', ['Radiodetection TX10', 'Vivax TX10']);

            // Signaal met sonde
            $table->enum('sonde_type', ['S18', 'Rioolsonde', 'Joepert', 'Joekeloekie', 'Boorsonde'])->nullable();
            // signaal met geleider
            $table->enum('geleider_frequentie', ['285hz', '320hz', '1khz', '4khz cd', '8khz', '8440khz', '33khz'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radio_detections');
    }
};
