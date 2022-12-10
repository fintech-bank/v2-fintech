@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
@endsection

@section("content")
    <div id="app" class="rounded container">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Nouvelle remise de chèque</h3>       
            </div>
            <form id="" action="" method="POST" enctype="multipart/formdata">
                <div class="card-body">
                    
                </div>
                <div class="card-footer">
                    <x-form.button />
                </div>
            </form>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.compte.check_deposit")
@endsection
