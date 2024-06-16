<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;

class Image extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function storeFile($file) {
        $image_path = "/images/{$this->id}/{$file->getClientOriginalName()}";
        Storage::disk('public')->put($image_path, file_get_contents($file));
        
        $thumb_file = InterventionImage::read($file->getRealPath());
        $thumb_file->scaleDown(height: 800, width: 900);
        $thumbnail_path = "/images/{$this->id}/thumb-{$file->getClientOriginalName()}";
        Storage::disk('public')->put(
            $thumbnail_path, (string) $thumb_file->toJpeg(quality: 40)
        );

        $this->update([
            'image_path' => $image_path,
            'thumbnail_path' => $thumbnail_path,
        ]);
    }
}