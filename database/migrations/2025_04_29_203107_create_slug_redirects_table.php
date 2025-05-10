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
        Schema::create('slug_redirects', function (Blueprint $table) {
            $table->id();
            $table->string('old_slug');
            $table->string('new_slug');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->timestamps();

            $table->index(['old_slug', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slug_redirects');
    }
};
