@extends('layouts.app')

@section('title', 'À propos')
@section('breadcrumb', 'À propos')
@section('page-title', 'À propos du SaLMeTE')
@section('page-subtitle', 'Contexte, objectifs et impact attendu du Salon Local des Métiers Techniques et Écologiques')

@section('content')
@include('partials.page-hero')

<section class="section">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-8">
                <h2 class="section-title">Contexte stratégique, institutionnel et territorial</h2>
                <div class="lead-soft mb-4">{!! nl2br(e(\App\Models\Setting::get('about_context'))) !!}</div>
                <div class="card p-4 bg-brand-soft">
                    <h3 class="h5 text-brand mb-3"><i class="bi bi-info-circle me-2"></i>L'événement en bref</h3>
                    <ul class="list-unstyled row g-3 mb-0">
                        <li class="col-sm-6 d-flex gap-3">
                            <i class="bi bi-calendar-event fs-4 text-gold"></i>
                            <div><strong>Dates</strong><br><span class="text-muted">{{ \App\Models\Setting::get('event_dates') }}</span></div>
                        </li>
                        <li class="col-sm-6 d-flex gap-3">
                            <i class="bi bi-geo-alt fs-4 text-gold"></i>
                            <div><strong>Lieu</strong><br><span class="text-muted">{{ \App\Models\Setting::get('event_location') }}</span></div>
                        </li>
                        <li class="col-sm-6 d-flex gap-3">
                            <i class="bi bi-building fs-4 text-gold"></i>
                            <div><strong>Organisateur</strong><br><span class="text-muted">{{ \App\Models\Setting::get('contact_org') }}</span></div>
                        </li>
                        <li class="col-sm-6 d-flex gap-3">
                            <i class="bi bi-people fs-4 text-gold"></i>
                            <div><strong>Participants visés</strong><br><span class="text-muted">200 participants, dont 50 jeunes et femmes en formation pratique</span></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card overflow-hidden mx-auto" style="max-width: 420px;">
                    <img src="{{ asset('images/brand/cover.jpg') }}" alt="Affiche officielle SaLMeTE 2026" class="card-img-top">
                    <div class="card-body text-center">
                        <span class="badge bg-gold text-dark"><i class="bi bi-image me-1"></i>Affiche officielle de l'édition 2026</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section odd-section">
    <div class="container">
        <h2 class="section-title text-center">Objectifs du salon</h2>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card h-100 p-4 border-start border-4 border-brand">
                    <h3 class="h5 text-brand"><i class="bi bi-bullseye me-2"></i>Objectif général</h3>
                    <p class="mb-0 text-muted">{{ \App\Models\Setting::get('about_goal_general') }}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 p-4 border-start border-4 border-warning">
                    <h3 class="h5 text-brand"><i class="bi bi-search me-2"></i>Objectif spécifique</h3>
                    <p class="mb-0 text-muted">{{ \App\Models\Setting::get('about_goal_specific') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title text-center">Alignement sur les Objectifs de Développement Durable</h2>
        <div class="row g-4">
            @foreach ([
                ['4', 'Éducation de qualité', 'Promotion de l’enseignement technique, de la formation professionnelle duale et de l’apprentissage des compétences pratiques.'],
                ['8', 'Travail décent et croissance', 'Soutien à l’emploi des jeunes, à l’entrepreneuriat local et à la valorisation de l’artisanat.'],
                ['9', 'Industrie, innovation et infrastructure', 'Valorisation des technologies endogènes et transfert d’innovations : séchoirs solaires, biodigesteurs, équipements adaptés.'],
                ['13', 'Lutte contre les changements climatiques', 'Promotion de solutions d’adaptation : énergies renouvelables, agroécologie, foyers améliorés.'],
            ] as $odd)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 p-4 text-center">
                        <div class="icon-circle icon-circle-gold mx-auto mb-3 fw-bold">{{ $odd[0] }}</div>
                        <h3 class="h6 text-brand">ODD {{ $odd[0] }} — {{ $odd[1] }}</h3>
                        <p class="small text-muted mb-0">{{ $odd[2] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section odd-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <h2 class="section-title">Résultats attendus</h2>
                <div class="lead-soft">{!! nl2br(e(\App\Models\Setting::get('about_results'))) !!}</div>
            </div>
            <div class="col-lg-6">
                <h2 class="section-title">Suivi & évaluation</h2>
                <div class="lead-soft">{!! nl2br(e(\App\Models\Setting::get('about_followup'))) !!}</div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-brand text-white text-center">
    <div class="container">
        <h2 class="fw-bold mb-3">Rejoignez la dynamique SaLMeTE 2026</h2>
        <p class="lead mb-4">Participants, exposants, partenaires : plusieurs façons de prendre part au salon.</p>
        <a href="{{ route('registrations.create') }}" class="btn btn-gold btn-lg me-2"><i class="bi bi-pencil-square me-2"></i>Je m'inscris</a>
        <a href="{{ route('partners') }}#sponsoring" class="btn btn-outline-light btn-lg">Devenir partenaire</a>
    </div>
</section>
@endsection
