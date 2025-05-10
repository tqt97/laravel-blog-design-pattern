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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->morphs('imageable');

            $table->string('disk')->default('public');
            $table->string('path');
            $table->string('url');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->string('alt_text')->nullable();

            $table->boolean('is_default')->default(false);
            $table->unsignedInteger('order')->default(0);

            $table->string('collection')->default('images')->index();

            $table->timestamps();

            $table->index('is_default');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
