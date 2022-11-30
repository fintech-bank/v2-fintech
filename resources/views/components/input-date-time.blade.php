<div class="mb-10">
    <label for="{{ $name }}" class="form-label {{ $required == true ? 'required' : '' }}">{{ $label }}</label>
    <input type="text" class="form-control form-control-solid {{ $class }} datetime" @if($placeholder) placeholder="{{ $placeholder }}" @else placeholder="{{ $label }}" @endif />
</div>
