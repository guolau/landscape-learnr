<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Snippet;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Snippet::class)
                ->constrained()
                ->onDelete('cascade');
            $table->string('thumbnail_path', length: 250)->nullable();
            $table->string('image_path', length: 250)->nullable();
            $table->string('alt_text', length: 150)->nullable();
            $table->string('attribution', length: 250)->nullable();
            $table->string('license', length: 50)->nullable();
            $table->string('license_url', length: 500)->nullable();
            $table->string('source_url', length: 500)->nullable();

            $table->timestamps();

            $table->index('snippet_id');
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
