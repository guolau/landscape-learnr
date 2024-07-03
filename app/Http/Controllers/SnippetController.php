<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Snippet;
use App\Models\StreetViewLink;
use App\Models\Tag;
use App\Models\Image;
use App\Http\Requests\SnippetRequest;

class SnippetController extends Controller
{
    public function index() {
        return inertia('snippets/Index', [
            'snippets' => Snippet::orderBy('title')
                ->with(['tags', 'images'])
                ->paginate(25)
        ]);
    }

    public function create() {
        return inertia('snippets/Create');
    }

    public function store(SnippetRequest $request) {
        $validated = $request->safe()->collect();
        
        $snippet = Snippet::create($validated->only(['title', 'body_html'])->toArray());
        
        // handle image inputs
        foreach($validated['images'] as $image_input) {
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
           
            if($image_input['file_input']['action'] == 'create')
                $image->storeFile($image_input['file_input']['file']);
        }

        // handle street view links
        foreach($validated['street_view_links'] ?? [] as $link) {
            StreetViewLink::create([
                'snippet_id' => $snippet->id,
                'title' => $link['title'],
                'url' => $link['url'],
            ]);
        }

        // handle tags
        foreach($validated['tags'] ?? [] as $tag_name) {
            $tag = Tag::firstOrCreate(['name' => $tag_name]);
            $snippet->tags()->attach($tag->id);
        }

        return redirect()->route('snippets.show', $snippet)
            ->with([
                'message' => 'Snippet successfully created', 
                'status' => 'success'
            ]);
    }

    public function show(Snippet $snippet) {
        return inertia('snippets/Show', [
            'snippet' => $snippet->load('images', 'street_view_links', 'tags')
        ]);
    }

    public function edit(Snippet $snippet) {
        $snippet = $snippet->load([
            'images:id,snippet_id,thumbnail_path,alt_text,attribution,license,license_url,source_url', 
            'street_view_links:id,snippet_id,title,url', 
            'tags:id,name'
        ]);

        $snippet->tags->transform(function ($tag) {
            return $tag->name;
        });

        return inertia('snippets/Edit', [
            'snippet' => $snippet
        ]);
    }

    public function update(Snippet $snippet, SnippetRequest $request) {
        $validated = $request->safe()->collect();
        
        $snippet->fill(
            $validated->only(['title', 'body_html'])->toArray()
        );

        if($validated['is_revised']) {
            $snippet->revised_at = now();
        }
        
        $snippet->save();
        
        // handle image inputs
        $image_ids = [];
        foreach($validated['images'] as $image_input) {
            $image = Image::find($image_input['id'] ?? null);
            // dd($image);
            
            if($image) {
                $image->update(
                    collect($image_input)->only([
                        'alt_text', 'attribution', 'source_url', 'license', 'license_url'
                    ])->toArray()
                );

                if($image_input['file_input'] ?? false) {
                    if($image_input['file_input']['action'] == 'create')
                        $image->storeFile($image_input['file_input']['file']);
                    else if($image_input['file_input']['action'] == 'delete') {
                        $image->removeFile();
                    }
                }
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
               
                if($image_input['file_input']['file'] ?? false)
                    $image->storeFile($image_input['file_input']['file']);
            }

            $has_content = collect($image->attributesToArray())->only([
                'image_path', 'alt_text', 'attribution', 'source_url', 'license', 'license_url' 
            ])->filter()->isNotEmpty();
            
            if($has_content) {
                $image_ids[] = $image->id;
            }
        }
        $snippet->images()->whereNotIn('images.id', $image_ids)->delete();

        // handle street view links
        $link_ids = [];
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

            $link_ids[] = $model->id; 
        }
        $snippet->street_view_links()->whereNotIn('street_view_links.id', $link_ids)->delete();

        // handle tags
        $tag_ids = [];
        foreach($validated['tags'] ?? [] as $tag_name) {
            $tag = Tag::firstOrCreate(['name' => $tag_name]);
            $tag_ids[] = $tag->id;
        }

        $snippet->tags()->sync($tag_ids);

        return redirect()->route('snippets.show', $snippet)
            ->with([
                'message' => 'Snippet successfully updated', 
                'status' => 'success'
            ]);
    }

    // public function destroy(): View {

    // }
}
