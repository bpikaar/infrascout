<?php

use App\Models\Report;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('test_trenches', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Report::class)->constrained()->cascadeOnDelete();

            $table->boolean('proefsleuf_gemaakt')->nullable()->default(false);
            $table->enum('manier_van_graven', ['Mini-graver', 'Handmatig']);
            $table->enum('type_grondslag', ['Zand','Grond','Klei','Veen']);
            $table->boolean('klic_melding_gedaan')->default(false);
            $table->string('klic_nummer')->nullable();
            $table->text('locatie')->nullable();
            $table->string('doel')->nullable();
            $table->text('bevindingen')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_trenches');
    }
};
