<div class="mb-10">
    <!--begin::Option-->
    <input type="radio" class="btn-check" name="{{ $name }}" value="{{ $value }}" @if($checked) checked="checked" @endif id="{{ $name }}"/>
    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="{{ $name }}">
        <i class="fa-solid fa-{{ $icon }} fs-3tx me-4"></i>

        <span class="d-block fw-semibold text-start">
            <span class="text-dark fw-bold d-block fs-3">{{ $label }}</span>
            <span class="text-muted fw-semibold fs-6">
                {!! $labelContent !!}
            </span>
        </span>
    </label>
    <!--end::Option-->
</div>
