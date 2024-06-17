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

    protected function bodyHtml(): Attribute {
        return Attribute::make(
            set: fn (string $value) => clean($value),
        );
    }

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function street_view_links() {
        return $this->hasMany(StreetViewLink::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
