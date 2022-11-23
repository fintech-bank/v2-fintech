<div class="mb-10">
    <label for="{{ $name }}" class="form-label {{ $required !== false ? "required" : "" }}">
        {{ $label }}
    </label>
    <select id="{{ $name }}" class="form-control selectpicker" name="{{ $name }}" data-live-search="true" data-header="{{ isset($placeholder) ?? $label }}" {{ $required !== false ? 'required' : "" }}>
        <option value=""></option>
        @foreach($datas as $data)
            <option value="{{ $data['id'] }}" @if(isset($value) && $data['id'] == $value) selected="selected" @endif data-content="{!! $data['value'] !!}">{{ $data['value'] }}</option>
        @endforeach
    </select>
</div>
