{{-- 
    $name
    $label?
    $is_html_editor?
--}}

@php
    $is_html_editor = $is_html_editor ?? false;
@endphp

<div class="ll-form-group @error($name) ll-input-error @enderror">
    <label for="{{ $name }}">{{ $label ?? ucwords($name) }}</label>
    <textarea id="{{ $name }}" name="{{ $name }}" 
        cols="30" rows="10" 
        class="@if('is_html_editor') ll-html-editor hidden @endif">{{ clean(old($name)) }}</textarea>
    @error($name)
        <small class="text-rose-700">{{ $errors->first($name) }}</small>
    @enderror
</div>

@once
@if($is_html_editor)
    @push('head')
        @vite('resources/js/ckeditor.js');
    @endpush

    @error($name) 
        <script> 
            document.getElementById("{{ $name }}").nextElementSibling.classList.add("ll-input-error"); 
        </script>
    @endif
@endif
@endonce