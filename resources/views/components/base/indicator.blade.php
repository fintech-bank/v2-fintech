@if($textOnly)
    <div>
        <div class="d-flex flex-row justify-content-center align-items-center">
            <span class="spinner-border border-primary spinner-border-sm align-middle me-2"></span>
        </div>
    </div>
@else
    <div>
        <div class="d-flex flex-row justify-content-center align-items-center">
            <span class="spinner-border text-primary spinner-border-sm align-middle me-2"></span>
            <span>{{ $text }}</span>
        </div>
    </div>
@endif
