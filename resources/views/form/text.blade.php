{{-- 
    $name
    $label?
--}}

<div class="ll-form-group @error($name) ll-input-error @enderror">
    <label for="{{ $name }}">{{ $label ?? ucwords($name) }}</label>
    <input id="{{ $name }}" name="{{ $name }}" 
        type="text" 
        class="form-input"
        value="{{ old($name) }}">
    @error($name)
        <small class="text-rose-700">{{ $errors->first($name) }}</small>
    @enderror
</div>