<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\TagType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(TagType::class)
                ->nullable()
                ->constrained()
                ->onDelete('set null');
            $table->string('name', length: 50);
            $table->string('description', length: 250)->nullable();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained(
                    table: 'tags', indexName: 'id'
                )->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
