<div class="mb-10">

    <label for="{{ $name }}" class="{{ $required ? 'required' : '' }} form-label">
        {{ $label }}
    </label>
    <select id="{{ $name }}" class="form-select form-select-solid selectpicker" @isset($placeholder) data-placeholder="{{ $placeholder }}" @else data-placeholder="{{ $label }}" @endisset name="{{ $name }}">
        @if(array_key_exists('key', $value))
            <option value="{{ $value['key'] }}">{{ $value['value'] }}</option>
        @else
            <option value=""></option>
        @endif
        @foreach(json_decode($datas, true) as $data)
            <option value="{{ isset($data['id']) ? $data['id'] : $data['name'] }}">{{ $data['name'] }}</option>
        @endforeach
    </select>
</div>
