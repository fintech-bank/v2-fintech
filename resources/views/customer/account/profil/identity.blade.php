@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Sécurité</h1>
        <!--end::Title-->
    </div>
@endsection

@section("content")
    <div id="app" class="rounded container">
        <x-base.underline
            title="Profil de {{ $customer->info->full_name }}"
            size="4"
            size-text="fs-2hx"
            color="bank"
            class="w-100 my-5 uppercase" />


        <x-base.underline
            title="Identité"
            size="4"
            size-text="fs-1"
            color="secondary"
            class="w-100 my-5" />

        <table class="table gy-7 gx-7">
            <tbody>
                <tr>
                    <td>Situation Familiale</td>
                    <td>{{ $customer->situation->family_situation }}</td>
                </tr>
                <tr>
                    <td>Nombre d'enfant</td>
                    <td>{{ $customer->situation->child }}</td>
                </tr>
                <tr>
                    <td>Activité</td>
                    <td>{{ $customer->situation->pro_category }}</td>
                </tr>
                <tr>
                    <td>Catégorie</td>
                    <td>{{ $customer->situation->pro_category_detail }}</td>
                </tr>
                <tr>
                    <td>Profession</td>
                    <td>{{ $customer->situation->pro_profession }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@section("script")
    @include("customer.scripts.account.profil.index")
@endsection
