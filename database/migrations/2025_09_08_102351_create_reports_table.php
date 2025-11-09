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

            $table->string('title');
            // company
            $table->string('company_location')->nullable();

            $table->timestamp('date_of_work');
            $table->foreignId('field_worker')->constrained('users');

            // Uitvraag opdrachtgever:
            $table->text('description');

            $table->string('work_hours');
            $table->string('travel_time');

            $table->text('results_summary')->nullable();
            $table->text('advice')->nullable();
            $table->text('follow_up')->nullable();
            $table->boolean('problem_solved')->default(false);
            $table->boolean('question_answered')->default(false);

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
