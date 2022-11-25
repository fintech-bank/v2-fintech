@extends("front.layouts.app")

@section("content")
    <div class="modal fade" tabindex="-1" id="verifyWithdraw">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Validation de votre Retrait</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-regular fa-xmark fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="">
                    <div class="modal-body">
                        <x-form.input
                            name=""
                    </div>
                    <div class="modal-footer">
                        <x-form.button text="Vérifier" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("scripts")

@endsection
