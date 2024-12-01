<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtmlOutput;
use App\Models\Tag;
use App\Models\Image;
use App\Models\StreetViewLink;

class Snippet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'body_html' => CleanHtmlOutput::class,
        'revised_at' => 'datetime',
    ];

    public function images() {
        return $this->hasMany(Image::class)->orderBy('id');
    }

    public function streetViewLinks() {
        return $this->hasMany(StreetViewLink::class)->orderBy('id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class)->orderBy('name');
    }
}
