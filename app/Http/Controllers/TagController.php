<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\TagCategory;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('tags/Index', [
            'tags' => Tag::query()
                ->when($request->category_id, fn ($query, $category_id) => 
                    $query->where('tag_category_id', $category_id)
                )
                ->orderBy('name')
                ->withCount('snippets')
                ->with(['tagCategory'])
                ->paginate(50)
                ->withQueryString(),
            'categories' => TagCategory::orderBy('name')->get(),
            'filters' => $request->only(['category_id'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
