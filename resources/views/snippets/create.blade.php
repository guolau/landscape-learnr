@extends('layouts.base')

@section('title') 
    Create Snippet
@endsection

@section('content')
<main class="ll-section mx-auto max-w-5xl">
    <h1>Create Snippet</h1>

    <form action="{{ route('snippets.store') }}" method="POST" enctype="multipart/form-data">
        @include('snippets.parts.form')

        <button type="submit">Create Snippet</button>
    </form>
</main>
@endsection