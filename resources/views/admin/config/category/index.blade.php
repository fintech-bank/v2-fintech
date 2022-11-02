@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Catégorie de document</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-muted text-hover-primary">Administration</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href=""
                   class="text-muted text-hover-primary">Configuration</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Catégorie de document</li>
        </ul>
    </div>
    <!--<div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>
        <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>
    </div>-->
@endsection

@section("content")
<div class="card card-flush shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Liste des catégories de document</h3>
        <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#AddCategory">
                <i class="fa-solid fa-plus me-2"></i> Nouvelle catégorie
            </button>
        </div>
    </div>
    <div class="card-body py-5">
        <div class="d-flex align-items-center position-relative my-1">
            <i class="fa-solid fa-search fa-lg position-absolute ms-4"></i>
            <input type="text" data-kt-category-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher..." />
        </div>
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_category_table" aria-describedby="Liste des banque">
            <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px" scope="col">Designation</th>
                <th class="min-w-75px" scope="col"></th>
            </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
            @foreach($categories as $category)
                <tr>
                    <td class="w-250px">{{ $category->name }}</td>
                    <td>
                        <button class="btn btn-circle btn-icon btn-primary btnEdit" data-category="{{ $category->id }}"><i class="fa-solid fa-edit" data-category="{{ $category->id }}"></i> </button>
                        <button class="btn btn-circle btn-icon btn-danger btnDelete" data-category="{{ $category->id }}"><i class="fa-solid fa-trash" data-category="{{ $category->id }}"></i> </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
    <div class="modal fade" tabindex="-1" id="AddCategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Ajout d'une catégorie</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formAddCategory" action="{{ route('admin.config.category.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            type="text"
                            name="name"
                            label="Nom de la catégorie"
                            required="true"
                            value="{{ old('name') }}" />
                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="EditCategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Edition d'une catégorie</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formEditCategory" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            type="text"
                            name="name"
                            label="Nom de la catégorie"
                            required="true"
                            value="{{ old('name') }}" />
                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("admin.scripts.config.category.index")
@endsection
