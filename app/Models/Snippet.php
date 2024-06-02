<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function bodyHtml(): Attribute {
        return Attribute::make(
            set: fn (string $value) => clean($value),
        );
    }
}
