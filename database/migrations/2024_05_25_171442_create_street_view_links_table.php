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
        Schema::create('street_view_links', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Snippet::class)
                ->constrained()
                ->onDelete('cascade');
            $table->string('title', length: 500);
            $table->string('url', length: 250);

            $table->timestamps();

            $table->index('snippet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('street_view_links');
    }
};
