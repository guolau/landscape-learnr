<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Tag;
use App\Models\Image;
use App\Models\StreetViewLink;

class Snippet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'revised_at' => 'datetime',
    ];

    protected function bodyHtml(): Attribute {
        return Attribute::make(
            set: fn (string $value) => clean($value),
        );
    }

    public function images() {
        return $this->hasMany(Image::class)->orderBy('id');
    }

    public function street_view_links() {
        return $this->hasMany(StreetViewLink::class)->orderBy('id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class)->orderBy('name');
    }
}
