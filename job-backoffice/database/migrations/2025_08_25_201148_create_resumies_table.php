<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resumies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('fileName');
            $table->string('fileUrl');
            $table->string('contactDetails')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('skills')->nullable();
            $table->longText('experience')->nullable();
            $table->longText('education')->nullable();

            $table->uuid('userId')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('userId')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resumies');
    }
};
