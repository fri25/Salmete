@extends('layouts.app')

@section('title', 'Exposants')
@section('breadcrumb', 'Exposants')
@section('page-title', 'Devenir exposant')
@section('page-subtitle', 'Une vitrine commerciale vivante pour les artisans, centres de formation, entreprises vertes et jeunes innovateurs')

@section('content')
@include('partials.page-hero')

<section class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Pourquoi exposer ?</h2>
                <p class="lead-soft">La foire d'exposition réunit 10 à 15 exposants qui présentent leurs technologies — séchoirs solaires, biodigesteurs, foyers améliorés, outils de transformation agricole — avec des démonstrations dynamiques en continu.</p>
                <ul class="list-unstyled d-grid gap-3 mt-3">
                    @foreach ([
                        ['bi-shop-window', 'Un stand aménagé sur les 3 jours du salon, dans un espace à forte affluence.'],
                        ['bi-megaphone', 'Une visibilité sur les supports officiels et les réseaux sociaux du salon.'],
                        ['bi-handshake', 'L’accès aux rencontres B2B avec acheteurs, ONG, mairies, coopératives et entreprises.'],
                        ['bi-trophy', 'La possibilité de concourir au Grand Prix de l’innovation « Solutions Atacora Durable ».'],
                    ] as $item)
                        <li class="d-flex gap-3">
                            <i class="bi {{ $item[0] }} fs-4 text-gold flex-shrink-0"></i>
                            <span class="text-muted">{{ $item[1] }}</span>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('registrations.create') }}?type=exposant" class="btn btn-brand btn-lg mt-3">
                    <i class="bi bi-pencil-square me-2"></i>Réserver mon stand
                </a>
            </div>
            <div class="col-lg-6">
                <div class="card p-4 bg-brand-soft">
                    <h3 class="h5 text-brand mb-3"><i class="bi bi-lightning-charge me-2"></i>Services subventionnés au public</h3>
                    <p class="text-muted">En parallèle des stands, des services techniques à coût réduit sont offerts au grand public pour attirer les usagers et montrer l'utilité directe des métiers techniques, notamment le scannage et le diagnostic automobile.</p>
                    <p class="text-muted mb-0">Chaque stand s'engage à proposer des démonstrations dynamiques en continu : la méthodologie du salon impose l'apprentissage « par le faire ».</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section odd-section">
    <div class="container">
        <h2 class="section-title text-center">Tarifs des stands</h2>
        <p class="text-center text-muted mb-4">
            Les tarifs des stands ne sont pas encore définis et seront communiqués prochainement.
            La visite du salon est <strong>libre et gratuite</strong> pour le public.
        </p>
        <div class="row g-4 justify-content-center">
            @foreach ($offers as $offer)
                <div class="col-md-6 col-lg-3">
                    <div class="card pricing-card h-100 text-center">
                        <div class="card-header-pricing">
                            <h3 class="h6 text-brand">{{ $offer->audience }}</h3>
                            <div class="price">
                                @if ($offer->price > 0)
                                    {{ number_format($offer->price, 0, ',', ' ') }} FCFA
                                @else
                                    {{ $offer->price_note ?: 'Tarif à définir' }}
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-3">{{ $offer->name }}</p>
                            @if ($offer->features)
                                <ul class="list-unstyled small d-grid gap-2 mb-0 text-start">
                                    @foreach (array_filter(array_map('trim', explode("\n", $offer->features))) as $feature)
                                        <li><i class="bi bi-check-circle-fill text-brand me-2"></i>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('partners') }}#sponsoring" class="btn btn-outline-brand">Voir toutes les formules de sponsoring</a>
        </div>
    </div>
</section>
@endsection
