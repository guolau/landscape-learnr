<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Snippet;
use App\Models\StreetViewLink;
use App\Models\Tag;
use App\Models\Image;

class SnippetController extends Controller
{
    // public function index(): View {

    // }

    public function create() {
        return inertia('snippets/Create');
    }

    public function store(Request $request) {
        $validated = collect($request->validate(
            [
                'title' => 'required|string|max:150',
                'body_html' => 'nullable|string|max:65500',

                'images' => 'array|max:10',
                'images.*.file' => 'nullable|file|max:512|mimes:jpeg,png,gif',
                'images.*.alt_text' => 'nullable|string|max:150',
                'images.*.attribution' => 'nullable|string|max:250',
                'images.*.source_url' => 'nullable|url|max:500',
                'images.*.license' => 'nullable|string|max:50',
                'images.*.license_url' => 'nullable|url|max:500',

                'street_view_links' => 'array|max:10',
                'street_view_links.*.title' => 'nullable|required_with:street_view_links.*.url|string|max:100',
                'street_view_links.*.url' => 'nullable|required_with:street_view_links.*.title|url|max:550',

                'tags' => 'array|max:20',
                'tags.*' => 'string|max:50',
            ], 
            [], 
            [
                'body_html' => 'body',

                'images.*.file' => 'image',
                'images.*.alt_text' => 'alt text',
                'images.*.attribution' => 'attribution',
                'images.*.source_url' => 'source URL',
                'images.*.license' => 'license',
                'images.*.license_url' => 'license URL',

                'street_view_links.*.title' => 'link title',
                'street_view_links.*.url' => 'link URL',

                'tags.*' => 'tag',
            ]
        ));
        
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
           
            if($image_input['file'])
                $image->storeFile($image_input['file']);
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

    // public function edit(): View {

    // }

    // public function update(): View {

    // }

    // public function destroy(): View {

    // }
}
