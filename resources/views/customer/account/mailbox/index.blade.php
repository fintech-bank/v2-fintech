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
            <!--begin::Card-->
            <div class="card">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Actions-->
                    <div class="d-flex flex-wrap gap-2">
                        @if(Request::segment(4) != 'Trash')
                        <!--begin::Checkbox-->
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-4 me-lg-7">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_inbox_listing .form-check-input" value="1" />
                        </div>
                        <!--end::Checkbox-->
                        @endif
                            @if(Request::segment(4) == '' || Request::segment(4) == 'Inbox')
                                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-action="mailbox-star-all" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Mettre en important">
                                    <i class="fa-solid fa-star fa-2x"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-action="mailbox-trash-all" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Mettre dans la corbeille">
                                    <i class="fa-solid fa-trash-o fa-2x"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-action="mailbox-reply" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Répondre">
                                    <i class="fa-solid fa-reply fa-2x"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-action="mailbox-forward" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Faire suivre">
                                    <i class="fa-solid fa-mail-forward fa-2x"></i>
                                </button>
                            @elseif(Request::segment(4) == 'Sent')
                                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-action="mailbox-star-all" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Mettre en important">
                                    <i class="fa-solid fa-star fa-2x"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-action="mailbox-trash-all" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Mettre dans la corbeille">
                                    <i class="fa-solid fa-trash-o fa-2x"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-action="mailbox-forward" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Faire suivre">
                                    <i class="fa-solid fa-mail-forward fa-2x"></i>
                                </button>
                            @elseif(Request::segment(4) == 'Drafts')
                                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-action="mailbox-star-all" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Mettre en important">
                                    <i class="fa-solid fa-star fa-2x"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-action="mailbox-trash-all" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Mettre dans la corbeille">
                                    <i class="fa-solid fa-trash-o fa-2x"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-action="mailbox-reply" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Répondre">
                                    <i class="fa-solid fa-reply fa-2x"></i>
                                </button>
                            @endif

                        <!--begin::Filter-->
                        <div>
                            <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                <span class="svg-icon svg-icon-2">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
																	</svg>
																</span>
                                <!--end::Svg Icon-->
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-inbox-listing-filter="show_all">All</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-inbox-listing-filter="show_read">Read</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-inbox-listing-filter="show_unread">Unread</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-inbox-listing-filter="show_starred">Starred</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-inbox-listing-filter="show_unstarred">Unstarred</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Filter-->
                    </div>
                    <!--end::Actions-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-2 position-absolute ms-4">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
																	<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
																</svg>
															</span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-inbox-listing-filter="search" class="form-control form-control-sm form-control-solid mw-100 min-w-125px min-w-lg-150px min-w-xxl-200px ps-12" placeholder="Search Inbox" />
                        </div>
                        <!--end::Search-->
                        @if(Agent::isMobile())
                        <!--begin::Toggle-->
                        <a href="#" class="btn btn-sm btn-icon btn-color-primary btn-light btn-active-light-primary" data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top" title="Toggle inbox menu" id="kt_inbox_aside_toggle">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen059.svg-->
                            <span class="svg-icon svg-icon-3 m-0">
																<svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<rect y="6" width="16" height="3" rx="1.5" fill="currentColor" />
																	<rect opacity="0.3" y="12" width="8" height="3" rx="1.5" fill="currentColor" />
																	<rect opacity="0.3" width="12" height="3" rx="1.5" fill="currentColor" />
																</svg>
															</span>
                            <!--end::Svg Icon-->
                        </a>
                        <!--end::Toggle-->
                        @endif
                    </div>
                    <!--end::Actions-->
                </div>
                <div class="card-body p-0">
                    <!--begin::Table-->
                    <table class="table table-hover table-row-dashed fs-6 gy-5 my-0" id="kt_inbox_listing">
                        <!--begin::Table head-->
                        <thead class="d-none">
                        <tr>
                            <th>Checkbox</th>
                            <th>Actions</th>
                            <th>Author</th>
                            <th>Title</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                        @foreach($messages as $message)
                            <tr class="{{ !$message->is_unread ? 'bg-light' : '' }}" data-mailbox-id="{{ $message->id }}" data-mailbox-flag-id="{{ $message->mailbox_flag_id }}" data-user-folder-id="{{ $message->mailbox_folder_id }}">
                                <td class="ps-9">
                                    @if(Request::segment(4) != 'Trash')
                                        <!--begin::Checkbox-->
                                            <div class="form-check form-check-sm form-check-custom form-check-solid mt-3">
                                                <input class="form-check-input check-message" type="checkbox" value="1" data-mailbox-id="{{ $message->id }}" data-mailbox-flag-id="{{ $message->mailbox_flag_id }}" />
                                            </div>
                                            <!--end::Checkbox-->
                                    @endif
                                </td>
                                <td class="min-w-80px">
                                    @if(Request::segment(4) != 'Trash')
                                    <!--begin::Star-->
                                    <a href="#" class="btn btn-icon {{ $message->is_important ? 'btn-warning' : 'btn-color-gray-400' }}  btn-active-color-primary w-35px h-35px mailbox-star" data-bs-toggle="tooltip" data-bs-placement="right" title="Important">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen029.svg-->
                                        <span class="svg-icon svg-icon-3">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor" />
											</svg>
										</span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--end::Star-->
                                    @endif
                                </td>
                                <!--begin::Author-->
                                <td class="w-150px w-md-175px">
                                    <a href="{{ route('agent.account.mailbox.show', $message->id) }}" class="d-flex align-items-center text-dark">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px me-3">
                                            {!! $message->sender->avatar_symbol !!}
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Name-->
                                        <span class="fw-semibold">{{ $message->sender->name }}</span>
                                        <!--end::Name-->
                                    </a>
                                </td>
                                <!--end::Author-->
                                <!--begin::Title-->
                                <td>
                                    <div class="text-dark mb-1">
                                        <!--begin::Heading-->
                                        <a href="{{ route('customer.account.mailbox.show', $message->id) }}" class="text-dark">
                                            <span class="fw-bold">{{ $message->subject }}</span>
                                            <span class="fw-bold d-none d-md-inine">-</span>
                                            <span class="d-none d-md-inine text-muted">{{ \Illuminate\Support\Str::limit($message->body, 50, '...') }}</span>
                                        </a>
                                        <!--end::Heading-->
                                    </div>
                                    <!--begin::Badges-->
                                    @if($message->attachments->count() > 0)
                                    <span class="badge badge-square badge-secondary"><i class="fa-solid fa-paperclip"></i> </span>
                                    @endif
                                    <!--<div class="badge badge-light-primary">inbox</div>
                                    <div class="badge badge-light-warning">task</div>-->
                                    <!--end::Badges-->
                                </td>
                                <!--end::Title-->
                                <!--begin::Date-->
                                <td class="w-100px text-end fs-7 pe-9">
                                    <span class="fw-semibold">
                                        @if($message->time_sent)
                                            {{ \Carbon\Carbon::parse($message->time_sent)->diffForHumans() }}
                                        @endif
                                    </span>
                                </td>
                                <!--end::Date-->
                            </tr>
                        @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Inbox App - Messages -->
@endsection

@section("script")
    @include("agent.scripts.account.mailbox.index")
@endsection
