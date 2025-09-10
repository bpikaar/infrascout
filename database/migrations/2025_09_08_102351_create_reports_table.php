<?php

use App\Models\Project;
use App\Models\User;
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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // creator
            $table->foreignIdFor(User::class)->constrained();

            // Project
            $table->foreignIdFor(Project::class)->constrained();

            // company

            $table->timestamp('date_of_work');
            $table->foreignId('field_worker')->constrained('users');

            // Uitvraag opdrachtgever:
            $table->string('cable_type');
            $table->string('material');
            $table->integer('diameter');
            $table->text('description');

            $table->string('work_hours');
            $table->string('travel_time');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
