<div class="mb-10">
    <label for="{{ $name }}" class="form-label {{ isset($required) ? "required" : "" }}">
        {{ $label }}
    </label>
    <select id="{{ $name }}" class="form-control selectpicker" name="{{ $name }}" data-live-search="true" data-header="{{ isset($placeholder) ?? $label }}">
        @foreach(json_decode($datas, true) as $data)
            <option value="{{ $data['id'] }}" @if(isset($value) && $data['id'] == $value) selected="selected" @endif data-content="{!! $data['value'] !!}">{{ $data['value'] }}</option>
        @endforeach
    </select>
</div>
