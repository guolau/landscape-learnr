<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Snippet;

class SnippetController extends Controller
{
    // public function index(): View {

    // }

    public function create() {
        return inertia('snippets/Create');
    }

    public function store(Request $request) {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:150',
                'body_html' => 'required|string|max:65500',
            ], 
            [], 
            [
                'body_html' => 'body',
            ]
        );

        $snippet = Snippet::create($validated);

        return redirect()->route('snippets.show');
    }

    public function show(): View {
        return view('snippets.show');
    }

    // public function edit(): View {

    // }

    // public function update(): View {

    // }

    // public function destroy(): View {

    // }
}
