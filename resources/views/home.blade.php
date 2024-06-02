@extends('layouts.base')

@push('head')
    @vite(['resources/js/app.js'])
@endpush

@section('content')
<main id="app">
    <div class="grid grid-cols-5 
        gap-5 mx-auto max-w-4xl">
        <select name="country" class="form-input col-span-2"><option>Kyrgystan</option></select>
        <input name="search" type="text" class="form-input col-span-3" placeholder="Search">
    </div>

    <h1 class="text-center my-8">Results for ...</h1>

    <div class="my-8">
        <Results></Results>
    </div>
</main>
@endsection

