@extends("agent.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Mes courriers</h1>

    </div>
    <!--<div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>
        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>
    </div>-->
@endsection

@section("content")
    <!--begin::Inbox App - Messages -->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="d-none d-lg-flex flex-column flex-lg-row-auto w-100 w-lg-275px" data-kt-drawer="true" data-kt-drawer-name="inbox-aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_inbox_aside_toggle">
            <!--begin::Sticky aside-->
            <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="inbox-aside-sticky" data-kt-sticky-offset="{default: false, xl: '100px'}" data-kt-sticky-width="{lg: '275px'}" data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                <!--begin::Aside content-->
                <div class="card-body">
                    <!--begin::Button-->
                    <a href="{{ route('customer.account.mailbox.create') }}" class="btn btn-primary fw-bold w-100 mb-8">Nouveau message</a>
                    <!--end::Button-->
                    <!--begin::Menu-->
                    <div class="menu menu-column menu-rounded menu-state-bg menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary mb-10">
                        <!--begin::Menu item-->
                        @foreach($folders as $folder)
                        <div class="menu-item mb-3">
                            <!--begin::Inbox-->
                            <a href="{{ route('customer.account.mailbox.index', [$folder->title]) }}" class="menu-link {{ Request::segment(4) == '' && $folder->title == 'Inbox' ? 'active' : (Request::segment(4) == $folder->title ? 'active' : '') }}">
								<span class="menu-icon">
                                    <i class="fa-solid fa-{{ $folder->icon }} fa-2x me-3"></i>
								</span>
								<span class="menu-title fw-bold">{{ $folder->title }}</span>
								@if($folder->title == 'Inbox' && $unreadMessages)
                                    <span class="badge badge-light-success">{{ $unreadMessages }}</span>
                                @endif
							</a>
                            <!--end::Inbox-->
                        </div>
                        <!--end::Menu item-->
                        @endforeach
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Aside content-->
            </div>
            <!--end::Sticky aside-->
        </div>
        <!--end::Sidebar-->
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
            <div class="card">
                <div class="card-header align-items-center">
                    <div class="card-title">
                        <h2 data-content="remap-subject">Nouveau Message</h2>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!--begin::Form-->
                    <form novalidate id="kt_inbox_compose_form" method="POST" action="{{ route('customer.account.mailbox.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Body-->
                        <div class="d-block">
                            <!--begin::To-->
                            <div class="d-flex align-items-center border-bottom px-8 min-h-50px">
                                <!--begin::Label-->
                                <div class="text-dark fw-bold w-75px">A:</div>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-transparent border-0" name="receiver_id[]" value="" data-kt-inbox-form="tagify" />
                                <!--end::Input-->
                            </div>
                            <!--end::To-->
                            <!--begin::Subject-->
                            <div class="border-bottom">
                                <input class="form-control form-control-transparent border-0 px-8 min-h-45px" name="subject" placeholder="Sujet" value="{{ old('subject') != null ? old('subject') : "" }}"/>
                            </div>
                            <!--end::Subject-->
                            <!--begin::Message-->
                            <textarea name="body" id="kt_inbox_form_editor" class="bg-transparent border-0 h-350px px-3"></textarea>
                            <!--end::Message-->
                            <!--begin::Attachments-->
                            <div class="attachmentsZone m-10">
                                <div class="fw-bolder mb-3">Fichiers Joins</div>
                                <ul class="contentZone"></ul>
                            </div>
                            <!--end::Attachments-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="d-flex flex-stack flex-wrap gap-2 py-5 ps-8 pe-5 border-top">
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center me-3">
                                <!--begin::Submit-->
                                <button class="btn btn-primary fs-bold px-6 me-3" name="submit" type="submit" value="1" data-kt-inbox-form="send">
                                    <span class="indicator-label">Envoyer</span>
                                    <span class="indicator-progress">Veuillez patienté...<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <!--end::Submit-->
                                <button type="submit" class="btn btn-icon btn-light fs-bold px-6 me-3" name="submit" value="2" data-bs-toggle="tooltip" title="Enregistrer">
                                    <span class="indicator-label"><i class="fa-solid fa-save"></i></span>
                                    <span class="indicator-progress"><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <button type="reset" class="btn btn-icon btn-light fs-bold px-6 me-3" data-bs-toggle="tooltip" title="Annuler">
                                    <span class="indicator-label"><i class="fa-solid fa-trash"></i></span>
                                    <span class="indicator-progress"><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <!--begin::Upload attachement-->
                                <div>
                                    <label for="inputFiles">
                                        <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary me-2" id="btn_attachments">
                                            <!--begin::Svg Icon | path: icons/duotune/communication/com008.svg-->
                                            <span class="svg-icon svg-icon-2 m-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M4.425 20.525C2.525 18.625 2.525 15.525 4.425 13.525L14.825 3.125C16.325 1.625 18.825 1.625 20.425 3.125C20.825 3.525 20.825 4.12502 20.425 4.52502C20.025 4.92502 19.425 4.92502 19.025 4.52502C18.225 3.72502 17.025 3.72502 16.225 4.52502L5.82499 14.925C4.62499 16.125 4.62499 17.925 5.82499 19.125C7.02499 20.325 8.82501 20.325 10.025 19.125L18.425 10.725C18.825 10.325 19.425 10.325 19.825 10.725C20.225 11.125 20.225 11.725 19.825 12.125L11.425 20.525C9.525 22.425 6.425 22.425 4.425 20.525Z" fill="currentColor" />
                                                    <path d="M9.32499 15.625C8.12499 14.425 8.12499 12.625 9.32499 11.425L14.225 6.52498C14.625 6.12498 15.225 6.12498 15.625 6.52498C16.025 6.92498 16.025 7.525 15.625 7.925L10.725 12.8249C10.325 13.2249 10.325 13.8249 10.725 14.2249C11.125 14.6249 11.725 14.6249 12.125 14.2249L19.125 7.22493C19.525 6.82493 19.725 6.425 19.725 5.925C19.725 5.325 19.525 4.825 19.125 4.425C18.725 4.025 18.725 3.42498 19.125 3.02498C19.525 2.62498 20.125 2.62498 20.525 3.02498C21.325 3.82498 21.725 4.825 21.725 5.925C21.725 6.925 21.325 7.82498 20.525 8.52498L13.525 15.525C12.325 16.725 10.525 16.725 9.32499 15.625Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <input type="file" id="inputFiles" name="attachments[]" class="inputAttachments d-none" multiple>
                                        </span>

                                    </label>
                                </div>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Footer-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
    <!--end::Inbox App - Messages -->
@endsection

@section("script")
    @include("customer.scripts.account.mailbox.create")
@endsection
