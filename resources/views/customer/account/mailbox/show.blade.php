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
                <div class="card-header align-items-center py-5 gap-5">
                    <!--begin::Actions-->
                    <div class="d-flex">
                        <!--begin::Back-->
                        <a href="{{ route('customer.account.mailbox.index') }}" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Retour">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                            <span class="svg-icon svg-icon-1 m-0">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="currentColor" />
									<path d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z" fill="currentColor" />
								</svg>
							</span>
                            <!--end::Svg Icon-->
                        </a>
                        <!--end::Back-->
                        <!--begin::Delete-->
                        <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                            <span class="svg-icon svg-icon-2 m-0">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
									<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
									<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
								</svg>
							</span>
                            <!--end::Svg Icon-->
                        </a>
                        <!--end::Delete-->
                        <!--begin::Mark as read-->
                        <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as read">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen028.svg-->
                            <span class="svg-icon svg-icon-2 m-0">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.5" x="7" y="2" width="14" height="16" rx="3" fill="currentColor" />
									<rect x="3" y="6" width="14" height="16" rx="3" fill="currentColor" />
								</svg>
							</span>
                            <!--end::Svg Icon-->
                        </a>
                        <!--end::Mark as read-->
                    </div>
                    <!--end::Actions-->

                </div>
                <div class="card-body">
                    <!--begin::Title-->
                    <div class="d-flex flex-wrap gap-2 justify-content-between mb-8">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <!--begin::Heading-->
                            <h2 class="fw-semibold me-3 my-1">{{ $mailbox->subject }}</h2>
                            <!--begin::Heading-->
                            <!--begin::Badges-->
                            @if($mailbox->flags()->first()->is_important)
                            <span class="badge badge-light-danger my-1">Important</span>
                            @endif
                            <!--end::Badges-->
                        </div>
                    </div>
                    <!--end::Title-->
                    <!--begin::Message accordion-->
                    <div data-kt-inbox-message="message_wrapper">
                        <!--begin::Message header-->
                        <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                            <!--begin::Author-->
                            <div class="d-flex align-items-center">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50 me-4">
                                    {!! $mailbox->sender->avatar_symbol !!}
                                </div>
                                <!--end::Avatar-->
                                <div class="pe-5">
                                    <!--begin::Author details-->
                                    <div class="d-flex align-items-center flex-wrap gap-1">
                                        <a href="#" class="fw-bold text-dark text-hover-primary">{{ $mailbox->sender->name }}</a>
                                        <span class="text-muted">{{ $mailbox->sender->email }}</span>
                                    </div>
                                    <!--end::Author details-->
                                    <!--begin::Message details-->
                                    <div data-kt-inbox-message="details">
                                        <span class="text-muted fw-semibold">à
                                        @foreach($mailbox->receivers as $receiver)
                                            {{ $receiver->user->name }},
                                        @endforeach
                                        </span>
                                        <!--begin::Menu toggle-->
                                        <a href="#" class="me-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
												</svg>
											</span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <!--end::Menu toggle-->
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4" data-kt-menu="true">
                                            <!--begin::Table-->
                                            <table class="table mb-0">
                                                <tbody>
                                                <!--begin::From-->
                                                <tr>
                                                    <td class="w-75px text-muted">From</td>
                                                    <td>{{ $mailbox->sender->name }}</td>
                                                </tr>
                                                <!--end::From-->
                                                <!--begin::Date-->
                                                <tr>
                                                    <td class="text-muted">Date</td>
                                                    <td>{{ \Carbon\Carbon::parse($mailbox->time_sent)->format('d/m/Y H:i') }}</td>
                                                </tr>
                                                <!--end::Date-->
                                                <!--begin::Subject-->
                                                <tr>
                                                    <td class="text-muted">Sujet</td>
                                                    <td>{{ $mailbox->subject }}</td>
                                                </tr>
                                                <!--end::Subject-->
                                                </tbody>
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Message details-->
                                    <!--begin::Preview message-->
                                    <div class="text-muted fw-semibold mw-450px d-none" data-kt-inbox-message="preview">With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important part....</div>
                                    <!--end::Preview message-->
                                </div>
                            </div>
                            <!--end::Author-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <!--begin::Date-->
                                <span class="fw-semibold text-muted text-end me-3">{{ \Carbon\Carbon::parse($mailbox->time_sent)->format('d/m/Y H:i') }}</span>
                                <!--end::Date-->
                                <div class="d-flex">
                                    <!--begin::Star-->
                                    <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Star">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen029.svg-->
                                        <span class="svg-icon svg-icon-2 m-0 @if($mailbox->flags()->first()->is_important) svg-icon-warning @endif">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor" />
											</svg>
										</span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--end::Star-->
                                    <!--begin::Reply-->
                                    <a href="#kt_inbox_reply_form" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Reply">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen055.svg-->
                                        <span class="svg-icon svg-icon-2 m-0">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor" />
												<path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor" />
												<path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor" />
											</svg>
										</span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--end::Reply-->
                                </div>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Message header-->
                        <!--begin::Message content-->
                        <div class="collapse fade show" data-kt-inbox-message="message">
                            <div class="py-5">
                                {!! $mailbox->body !!}
                            </div>
                        </div>
                        <!--end::Message content-->
                    </div>
                    <!--end::Message accordion-->
                    <div class="separator my-6"></div>
                    @foreach($mailbox->replies as $reply)
                    <!--begin::Message accordion-->
                    <div data-kt-inbox-message="message_wrapper">
                        <!--begin::Message header-->
                        <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                            <!--begin::Author-->
                            <div class="d-flex align-items-center">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50 me-4">
                                    {!! $reply->sender->avatar_symbol !!}
                                </div>
                                <!--end::Avatar-->
                                <div class="pe-5">
                                    <!--begin::Author details-->
                                    <div class="d-flex align-items-center flex-wrap gap-1">
                                        <a href="#" class="fw-bold text-dark text-hover-primary">{{ $reply->sender->name }}</a>
                                    </div>
                                    <!--end::Author details-->
                                    <!--begin::Message details-->
                                    <div class="d-none" data-kt-inbox-message="details">
                                        <span class="text-muted fw-semibold">to
                                        @foreach($reply->receivers as $receiver)
                                            {{ $receiver->user->name }},
                                        @endforeach
                                        </span>
                                        <!--begin::Menu toggle-->
                                        <a href="#" class="me-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
												</svg>
											</span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <!--end::Menu toggle-->
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4" data-kt-menu="true">
                                            <!--begin::Table-->
                                            <table class="table mb-0">
                                                <tbody>
                                                <!--begin::From-->
                                                <tr>
                                                    <td class="w-75px text-muted">From</td>
                                                    <td>{{ $reply->sender->name }}</td>
                                                </tr>
                                                <!--end::From-->
                                                <!--begin::Date-->
                                                <tr>
                                                    <td class="text-muted">Date</td>
                                                    <td>{{ \Carbon\Carbon::parse($reply->time_sent)->format('d/m/Y H:i') }}</td>
                                                </tr>
                                                <!--end::Date-->
                                                <!--begin::Subject-->
                                                <tr>
                                                    <td class="text-muted">Sujet</td>
                                                    <td>{{ $reply->subject }}</td>
                                                </tr>
                                                <!--end::Subject-->
                                                </tbody>
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::Message details-->
                                    <!--begin::Preview message-->
                                    <div class="text-muted fw-semibold mw-450px" data-kt-inbox-message="preview">{!! \Illuminate\Support\Str::limit($reply->body, 100) !!}</div>
                                    <!--end::Preview message-->
                                </div>
                            </div>
                            <!--end::Author-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <!--begin::Date-->
                                <span class="fw-semibold text-muted text-end me-3">{{ \Carbon\Carbon::parse($reply->time_sent)->format('d/m/Y H:i') }}</span>
                                <!--end::Date-->
                                <div class="d-flex">
                                    <!--begin::Star-->
                                    <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Star">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen029.svg-->
                                        <span class="svg-icon svg-icon-2 @if($mailbox->flags()->first()->is_important) svg-icon-warning @endif m-0">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor" />
											</svg>
										</span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--end::Star-->
                                    <!--begin::Reply-->
                                    <a href="#kt_inbox_reply_form" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Reply">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen055.svg-->
                                        <span class="svg-icon svg-icon-2 m-0">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor" />
												<path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor" />
												<path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor" />
											</svg>
										</span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--end::Reply-->
                                </div>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Message header-->
                        <!--begin::Message content-->
                        <div class="collapse fade" data-kt-inbox-message="message">
                            <div class="py-5">
                                {!! $reply->body !!}
                            </div>
                        </div>
                        <!--end::Message content-->
                    </div>
                    <!--end::Message accordion-->
                    <div class="separator my-6"></div>
                    <!--begin::Message accordion-->
                    @endforeach
                    <!--begin::Form-->
                    <form id="kt_inbox_reply_form" class="rounded border mt-10">
                        <!--begin::Body-->
                        <div class="d-block">
                            <!--begin::To-->
                            <div class="d-flex align-items-center border-bottom px-8 min-h-50px">
                                <!--begin::Label-->
                                <div class="text-dark fw-bold w-75px">To:</div>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control border-0" name="compose_to" value="@foreach($mailbox->receivers as $user) {{ $user->user->email }}, @endforeach" data-kt-inbox-form="tagify" />
                                <!--end::Input-->
                            </div>
                            <!--end::To-->
                            <!--begin::Subject-->
                            <div class="border-bottom">
                                <input class="form-control border-0 px-8 min-h-45px" name="compose_subject" value="RE: {{ $mailbox->subject }}" />
                            </div>
                            <!--end::Subject-->
                            <!--begin::Message-->
                            <textarea name="body" id="kt_inbox_form_editor" class="bg-transparent border-0 h-350px px-3"></textarea>
                            <!--end::Message-->
                            <!--begin::Attachments-->
                            <div class="attachmentsZone m-10">
                                <div class="fw-bolder mb-3">Fichiers Joins</div>
                                <div class="d-flex flex-column">
                                    @if($mailbox->attachments->count())
                                        @foreach($mailbox->attachments as $attachment)
                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <div class="d-flex flex-start align-items-center">
                                                    <i class="fa-solid {{ in_array(pathinfo(public_path('uploads/mailbox/' . $attachment->attachment), PATHINFO_EXTENSION), ["jpg", "jpeg", "png", "gif"])?'fa-image':'fa-file' }} me-2"></i>
                                                    <a href="{{ url('uploads/mailbox/' . $attachment->attachment) }}" target="_blank" class="me-2">{{ $attachment->attachment }}</a> <em>({{ round(filesize(public_path('uploads/mailbox/' . $attachment->attachment))/1024, 2) }} KB)</em>
                                                </div>
                                                <div class="d-flex flex-end">
                                                    <a href="{{ url('uploads/mailbox/' . $attachment->attachment) }}" target="_blank" class="btn btn-default btn-xs pull-right"><i class="fa-solid fa-cloud-download"></i></a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
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
