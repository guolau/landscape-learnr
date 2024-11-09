<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Setting::create([
            'name' => 'search_page_dropdown_tag_category_id',
            'value' => null,
            'description' => 'ID of the tag category used in the search page filter dropdown.',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('name', 'search_page_dropdown_tag_category_id')->delete();
    }
};
