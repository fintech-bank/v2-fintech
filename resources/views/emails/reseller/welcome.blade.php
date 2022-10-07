@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ $reseller->dab->name }}</span>
            <p class="fw-bolder">Bienvenue dans le groupe des distributeurs de la banque FINTECH.</p>
            <p>Vous trouverez en pièces jointes, votre contrat de distributeur.</p>
            <p>
                Votre TPE de distributeur va vous être envoyer dans les 48H.<br>
                Un email vous sera transmis lors de son envoie.
            </p>
            <p>Voici vos identifiants de connexion:</p>
            <ul>
                <li><strong>Identifiant:</strong> {{ $reseller->user->identifiant }}</li>
                <li><strong>Mot de passe temporaire:</strong> {{ $password }}</li>
            </ul>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

