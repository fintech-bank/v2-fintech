<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!-- Menu Sidebar -->
        <div class="d-flex flex-row justify-content-between bg-bank shadow-sm border border-bottom-1 h-30px">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active text-white fs-8" aria-current="page" href="#">Particulier</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white fs-8" aria-current="page" href="#">Professionnel</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white fs-8" aria-current="page" href="#">Association</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white fs-8" aria-current="page" href="#">Institution public</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-white fs-8" aria-current="page" href="#"><i class="fa-solid fa-location-dot me-2"></i> Agences</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white fs-8" aria-current="page" href="#"><i class="fa-solid fa-triangle-exclamation me-2"></i> Aide et contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Menu -->
        <div class="d-flex flex-row justify-content-between align-items-center shadow-lg border px-10 h-100px">
            <nav class="navbar navbar-expand-lg bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="/storage/logo/logo_long_color.png" class="w-200px" />
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
            <nav class="navbar navbar-expand-lg bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item me-5">
                                <a class="nav-link fw-bolder fs-3" href="{{ route('part.compte') }}">Comptes & Cartes</a>
                            </li>
                            <li class="nav-item me-5">
                                <a class="nav-link fw-bolder fs-3" href="#">Emprunter</a>
                            </li>
                            <li class="nav-item me-5">
                                <a class="nav-link fw-bolder fs-3" href="#">Epargner</a>
                            </li>
                            <li class="nav-item me-5">
                                <a class="nav-link fw-bolder fs-3" href="#">Assurer</a>
                            </li>
                            <li class="nav-item me-5">
                                <a class="nav-link fw-bolder fs-3" href="#">Nos conseils</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="d-flex flex-row align-items-center">
                <a href="" class="me-10"><i class="fa-solid fa-search fa-lg text-gray-500"></i> </a>
                <a href="{{ route('login') }}" class="btn btn-circle btn-danger btn-lg fs-4 px-10 py-5"><i class="fa-solid fa-lock fa-lg"></i> Espace Client</a>
            </div>
        </div>
    </div>
</div>
