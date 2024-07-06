<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Models\Snippet;
use App\Models\StreetViewLink;
use App\Models\Tag;
use App\Models\Image;

class SnippetService {
    public function store(Collection $validated): Snippet {
        $snippet = Snippet::create($validated->only(['title', 'body_html'])->toArray());
        
        $this->handleImages($snippet, $validated);
        $this->handleStreetViewLinks($snippet, $validated);
        $this->handleTags($snippet, $validated);

        return $snippet;
    }

    public function update(Collection $validated, Snippet $snippet): Snippet {
        $snippet->fill(
            $validated->only(['title', 'body_html'])->toArray()
        );

        if($validated['is_revised']) {
            $snippet->revised_at = now();
        }
        
        $snippet->save();
        
        $this->handleImages($snippet, $validated);
        $this->handleStreetViewLinks($snippet, $validated);
        $this->handleTags($snippet, $validated);

        return $snippet;
    }

    private function handleImages(Snippet $snippet, Collection $validated) {
        $sync_ids = [];

        foreach($validated['images'] as $image_input) {
            $image = Image::find($image_input['id'] ?? null);

            // update string information
            if($image) {
                $image->update(
                    collect($image_input)->only([
                        'alt_text', 'attribution', 'source_url', 'license', 'license_url'
                    ])->toArray()
                );
            } else {
                $image = Image::create(
                    array_merge(
                        [
                            'snippet_id' => $snippet->id,
                        ],
                        collect($image_input)->only([
                            'alt_text', 'attribution', 'source_url', 'license', 'license_url'
                        ])->toArray()
                    )
                );
            }

            // handle image file
            if($image_input['file_input'] ?? false) {
                if($image_input['file_input']['action'] == 'create')
                    $image->storeFile($image_input['file_input']['file']);
                else if($image_input['file_input']['action'] == 'delete') {
                    $image->removeFile();
                }
            }

            // check if the important columns are empty
            $has_content = collect($image->attributesToArray())->only([
                'image_path', 'alt_text', 'attribution', 'source_url', 'license', 'license_url' 
            ])->filter()->isNotEmpty();
            
            if($has_content) {
                $sync_ids[] = $image->id;
            }
        }

        $snippet->images()->whereNotIn('images.id', $sync_ids)->delete();
    }

    private function handleStreetViewLinks(Snippet $snippet, Collection $validated) {
        $sync_ids = [];

        foreach($validated['street_view_links'] ?? [] as $link) {
            $model = StreetViewLink::find($link['id'] ?? null);
    
            if($model) {
                $model->update([
                    'title' => $link['title'], 
                    'url' => $link['url']
                ]);
            } else {
                $model = StreetViewLink::create([
                    'snippet_id' => $snippet->id,
                    'title' => $link['title'],
                    'url' => $link['url'],
                ]);
            }

            $sync_ids[] = $model->id; 
        }

        $snippet->street_view_links()->whereNotIn('street_view_links.id', $sync_ids)->delete();
    }

    private function handleTags(Snippet $snippet, Collection $validated) {
        $sync_ids = [];

        foreach($validated['tags'] ?? [] as $name) {
            $tag = Tag::firstOrCreate(['name' => $name]);
            $sync_ids[] = $tag->id;
        }

        $snippet->tags()->sync($sync_ids);
    }

    public function destroy(Snippet $snippet): bool {
        Image::destroy($snippet->images->pluck('id'));

        $snippet->delete();

        return true;
    }
}