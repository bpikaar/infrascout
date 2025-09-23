<?php

use App\Models\Report;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gyroscopes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Report::class)->constrained()->cascadeOnDelete();

            // Dutch column names as requested
            $table->enum('type_boring', ['HDD', 'Persing', 'Overig']);
            $table->string('intredepunt');
            $table->string('uittredepunt');
            $table->decimal('lengte_trace', 8, 2)->nullable();
            $table->boolean('bodemprofiel_ingemeten_met_gps')->default(false);
            $table->decimal('diameter_buis', 8, 2)->nullable();
            $table->enum('materiaal', ['PVC','PE','HDPE','Gietijzer','Staal','RVS','Overig'])->nullable();
            $table->enum('ingemeten_met', ['Trektouw', 'Cable-pusher (glasfiber pees)'])->nullable();
            $table->text('bijzonderheden')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gyroscopes');
    }
};
