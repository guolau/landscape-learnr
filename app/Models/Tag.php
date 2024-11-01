<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TagCategory;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function snippets() {
        return $this->belongsToMany(Snippet::class);
    }
    
    public function tagCategory() {
        return $this->belongsTo(TagCategory::class);
    }
}
