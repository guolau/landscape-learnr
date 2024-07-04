<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Snippet;
use App\Http\Requests\SnippetRequest;
use App\Services\SnippetService;

class SnippetController extends Controller
{
    private SnippetService $snippetService;

    public function __construct(SnippetService $snippetService) {
        $this->snippetService = $snippetService;
    }

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
        $snippet = $this->snippetService->store($request->safe()->collect());

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

        $snippet->images->transform(function ($image) {
            $image->file_input = (object)[
                'action' => null,
                'file' => $image->thumbnail_path ? asset("storage/$image->thumbnail_path") : null,
            ];

            return $image;
        });

        return inertia('snippets/Edit', [
            'snippet' => $snippet
        ]);
    }

    public function update(Snippet $snippet, SnippetRequest $request) {
        $this->snippetService->update(
            $request->safe()->collect(), 
            $snippet
        );
        
        return redirect()->route('snippets.show', $snippet)
            ->with([
                'message' => 'Snippet successfully updated', 
                'status' => 'success'
            ]);
    }

    // public function destroy(): View {

    // }
}
