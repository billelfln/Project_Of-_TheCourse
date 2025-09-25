<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jobApplications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->decimal('aiGeneratedScore', 5, 2)->nullable();
            $table->text('aiGeneratedFeedback')->nullable();

            $table->uuid('jobVacancyId')->nullable();
            $table->uuid('resumeId')->nullable();
            $table->uuid('userId')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('jobVacancyId')->references('id')->on('jobVacancies')->onDelete('restrict');
            $table->foreign('resumeId')->references('id')->on('resumies')->onDelete('restrict');
            $table->foreign('userId')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobApplications');
    }
};
