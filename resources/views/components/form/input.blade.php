@if($typeInput == 'normal')
    @if($type == 'hidden')
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @else
        <div class="mb-10 me-3">
            @if($help == true)
                <label for="{{ $name }}" class="{{ $required == true ? 'required' : '' }} form-label">
                    {{ $label }}
                    <i class="fas fa-info-circle text-primary fa-lg"
                       data-bs-toggle="popover"
                       data-bs-custom-class="popover-dark" title="Aide" data-bs-content="{{ $helpText }}"></i>
                </label>
            @else
                <label for="{{ $name }}" class="{{ $required == true ? 'required' : '' }} form-label">
                    {{ $label }}
                </label>
            @endif
            <input
                type="{{ $type ? $type : 'text' }}"
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ old($name, isset($value) ? $value : '') }}"
                {{ $required ? 'required' : ''}}
                {{ $autofocus ? 'autofocus' : '' }}
                class="form-control form-control-solid {{ $errors->has($name) ? ' is-invalid' : '' }} {{ $class }}"
                @if($placeholder) placeholder="{{ $placeholder }}" @else placeholder="{{ $label }}" @endif/>

            @if($text)
                <p class="text-muted">{!! $text !!}</p>
            @endif

            @if ($errors->has($name))
                <div class="invalid-feedback">
                    {{ $errors->first($name) }}
                </div>
            @endif
        </div>
    @endif

@else
    <div class="mb-10">
        <div class="form-floating">
            <input type="{{ $type ? $type : 'text' }}"
                   value="{{ old($name, isset($value) ?? '') }}"
                   class="form-control form-control-solid {{ $errors->has($name) ? ' is-invalid' : '' }} {{ $class }}"
                   name="{{ $name }}" id="{{ $name }}" @if($placeholder) placeholder="{{ $placeholder }}"
                   @else placeholder="{{ $label }}" @endif/>
            <label for="{{ $name }}">{{ $label }}</label>
        </div>
    </div>
@endif
