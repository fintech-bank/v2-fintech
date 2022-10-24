<div class="mb-10">
    <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    <input class="form-control form-control-solid" type="file" name="{{ $name }}" id="{{ $name }}">
</div>
