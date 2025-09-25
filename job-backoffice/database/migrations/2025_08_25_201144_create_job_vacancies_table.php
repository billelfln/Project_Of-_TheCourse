<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jobVacancies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->decimal('salary', 12, 2)->nullable();
            $table->enum('type', ['Full-Time', 'Contract', 'Remote', 'hybrid'])->default('Full-Time');

            $table->uuid('jobCategoryId')->nullable();
            $table->uuid('companyId')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('jobCategoryId')->references('id')->on('jobCategories')->onDelete('restrict');
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobVacancies');
    }
};
