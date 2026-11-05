@extends('layouts.app')

@section('title', 'Partenaires & sponsoring')
@section('breadcrumb', 'Partenaires & sponsoring')
@section('page-title', 'Partenaires & sponsoring')
@section('page-subtitle', 'Un écosystème d’acteurs mobilisés pour la jeunesse, l’emploi local et la résilience climatique — rejoignez-le et investissez dans l’avenir du territoire.')

@section('content')
@include('partials.page-hero')

{{-- ============================================================= NAVIGATION INTERNE --}}
<div class="container">
    <nav class="section-switch" aria-label="Sections de la page">
        <a href="#partenaires"><i class="bi bi-people me-2"></i>Nos partenaires</a>
        <a href="#pourquoi"><i class="bi bi-lightbulb me-2"></i>Pourquoi nous rejoindre</a>
        <a href="#sponsoring"><i class="bi bi-megaphone me-2"></i>Formules de sponsoring</a>
    </nav>
</div>

{{-- ============================================================= PARTENAIRES --}}
<section class="section" id="partenaires">
    <div class="container">
        <div class="section-heading" data-reveal>
            <div class="eyebrow eyebrow-soft"><span class="sun-dot"></span>Ils nous soutiennent</div>
            <h2 class="has-accent-text">Nos <strong>partenaires</strong></h2>
        </div>
        @forelse ($partners as $category => $group)
            <h3 class="h4 mb-3" data-reveal>{{ $category }} <span class="text-muted fs-6 fw-normal">({{ $group->count() }})</span></h3>
            <div class="row g-3 mb-5" data-reveal>
                @foreach ($group as $partner)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="partner-card">
                            @if ($partner->logo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($partner->logo) }}" alt="{{ $partner->name }}" class="partner-logo">
                            @else
                                <div class="partner-initials">{{ \Illuminate\Support\Str::of($partner->name)->substr(0, 2)->upper() }}</div>
                            @endif
                            <div class="partner-name">{{ $partner->name }}</div>
                            @if ($partner->description)
                                <p class="small text-muted mt-2 mb-0">{{ $partner->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <p class="text-muted text-center">La liste des partenaires sera actualisée prochainement.</p>
        @endforelse
    </div>
</section>

{{-- ============================================================= POURQUOI --}}
<section class="section odd-section" id="pourquoi">
    <div class="container">
        <div class="section-heading" data-reveal>
            <div class="eyebrow eyebrow-soft"><span class="sun-dot"></span>Devenir partenaire</div>
            <h2 class="has-accent-text">Pourquoi <strong>nous rejoindre</strong> ?</h2>
        </div>
        <div class="row g-4" data-reveal>
            @foreach ([
                ['bi-bullseye', 'Incarner votre RSE', 'Affirmez votre leadership en faveur de l’emploi des jeunes, de l’entrepreneuriat féminin et de la résilience climatique.'],
                ['bi-lightbulb', 'Soutenir des solutions concrètes', 'Propulsez des innovations locales à fort impact économique et environnemental.'],
                ['bi-megaphone', 'Maximiser votre visibilité', 'Associez votre image à un événement phare, largement médiatisé à l’échelle régionale et nationale.'],
                ['bi-person-badge', 'Accéder à un vivier de talents', 'Identifiez en avant-première les meilleurs profils techniques et les futurs champions de l’agroécologie.'],
            ] as $reason)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 p-4 text-center">
                        <span class="icon-circle {{ $loop->even ? 'icon-circle-gold' : '' }} mx-auto mb-3"><i class="bi {{ $reason[0] }}"></i></span>
                        <h3 class="h6">{{ $reason[1] }}</h3>
                        <p class="small text-muted mb-0">{{ $reason[2] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================= FORMULES --}}
<section class="section" id="sponsoring">
    <div class="container">
        <div class="section-heading" data-reveal>
            <div class="eyebrow eyebrow-soft"><span class="sun-dot"></span>Sponsoring & mécénat</div>
            <h2 class="has-accent-text">Formes de soutien & <strong>options de sponsoring</strong></h2>
        </div>
        <div class="row g-4" data-reveal>
            @foreach ($offers as $offer)
                <div class="col-md-6 col-lg-4">
                    <div class="card pricing-card h-100 {{ $offer->badge ? 'featured' : '' }}">
                        <div class="card-header-pricing">
                            @if ($offer->badge)
                                <span class="badge bg-gold text-dark mb-2">{{ $offer->badge }}</span>
                            @endif
                            <h3 class="h6 text-brand mb-1">{{ $offer->name }}</h3>
                            <div class="price">
                                @if ($offer->price > 0)
                                    {{ number_format($offer->price, 0, ',', ' ') }} FCFA
                                @else
                                    {{ trim($offer->price_note ?? 'Sur devis') }}
                                @endif
                            </div>
                            @if ($offer->price > 0 && $offer->price_note)
                                <small class="text-muted">{{ $offer->price_note }}</small>
                            @endif
                        </div>
                        <div class="card-body">
                            @if ($offer->description)
                                <p class="text-muted small">{{ $offer->description }}</p>
                            @endif
                            @if ($offer->features)
                                <ul class="list-unstyled small d-grid gap-2 mb-0">
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
        <p class="text-center text-muted small mt-4">
            <i class="bi bi-info-circle me-1"></i>Les tarifs s'entendent pour la durée totale du salon (3 jours). Une facture et une convention de partenariat sont établies pour chaque soutien.
        </p>
    </div>
</section>

{{-- ============================================================= CTA --}}
<section class="cta-section text-center">
    <div class="container" data-reveal>
        <h2 class="mb-3">Rejoignez l'écosystème SaLMeTE</h2>
        <p class="lead mb-4">Déposez votre demande via le formulaire « exposant / sponsor » ou contactez directement l'organisation.</p>
        <div class="cta-checks mb-5">
            <span><i class="bi bi-telephone"></i>{{ \App\Models\Setting::get('contact_phone') }}</span>
            <span><i class="bi bi-envelope"></i>{{ \App\Models\Setting::get('contact_email') }}</span>
        </div>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('registrations.create') }}?type=exposant" class="btn btn-gold btn-lg btn-has-icon">
                Déposer une demande
                <span class="btn-icon"><i class="bi bi-arrow-up-right"></i></span>
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">Nous écrire</a>
        </div>
    </div>
</section>
@endsection
