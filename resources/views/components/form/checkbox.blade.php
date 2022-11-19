<div class="mb-5 {{ $class ?? '' }}">
    <div class="form-check form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" name="{{ $name }}" value="{{ $value }}" id="{{ $name }}" {{ $checked == true ? 'checked' : '' }}/>
        <label class="form-check-label {{ $class ?? '' }}" for="{{ $name }}">
            {{ $label }}
        </label>
    </div>
</div>
