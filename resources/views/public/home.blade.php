@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
{{-- ============================================================= HERO --}}
<section class="sm-hero">
    <span class="leaf leaf-lime leaf-1"></span>
    <span class="leaf leaf-white leaf-2"></span>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="eyebrow"><span class="sun-dot"></span>{{ \App\Models\Setting::get('site_edition') }}</div>
                <h1 class="sm-hero-title animated-text" data-animated-text>{{ \App\Models\Setting::get('site_tagline') }}</h1>
                <p class="sm-hero-text animated-text" data-animated-text data-delay="0.5">{{ \App\Models\Setting::get('hero_theme') }}</p>

                <div class="sm-hero-meta my-4" data-reveal>
                    <span><i class="bi bi-calendar-event"></i>{{ \App\Models\Setting::get('event_dates') }}</span>
                    <span><i class="bi bi-geo-alt"></i>{{ \App\Models\Setting::get('event_location') }}</span>
                </div>

                <div class="sm-hero-actions d-flex flex-wrap gap-3" data-reveal>
                    <a href="{{ route('registrations.create') }}" class="btn btn-gold btn-lg btn-has-icon">
                        Je m'inscris
                        <span class="btn-icon"><i class="bi bi-arrow-up-right"></i></span>
                    </a>
                    <a href="{{ route('program') }}" class="btn btn-outline-light btn-lg">Découvrir le programme</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sm-hero-visual" data-reveal>
                    <span class="sun" aria-hidden="true"></span>
                    <div class="frame">
                        <picture>
                            <source srcset="{{ asset('images/brand/illustration.webp') }}" type="image/webp">
                            <img src="{{ asset('images/brand/illustration.jpg') }}" width="1254" height="1254"
                                 alt="Illustration : jeunes acteurs de l'agriculture durable, de l'artisanat vert, de l'énergie solaire et de la transformation agroalimentaire">
                        </picture>
                    </div>
                    <div class="badge-floating">
                        <i class="bi bi-people-fill fs-3 text-lime"></i>
                        <span><strong>{{ \App\Models\Setting::get('stat_participants') }}</strong>{{ \App\Models\Setting::get('stat_participants_label') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================= PARTENAIRES (bandeau) --}}
@if ($partners->isNotEmpty())
    <section class="pt-5">
        <div class="container">
            <p class="text-center small text-uppercase fw-semibold text-muted mb-4" style="letter-spacing:.12em;">Ils soutiennent le SaLMeTE</p>
            <div class="logo-marquee">
                <div class="logo-track">
                    @foreach ([1, 2] as $loopIndex)
                        @foreach ($partners as $partner)
                            <span class="logo-item" @if ($loopIndex === 2) aria-hidden="true" @endif>
                                @if ($partner->logo)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($partner->logo) }}" alt="" loading="lazy">
                                @endif
                                {{ $partner->name }}
                            </span>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

{{-- ============================================================= 3 MISSIONS --}}
<section class="section">
    <div class="container">
        <div class="section-heading" data-reveal>
            <div class="eyebrow eyebrow-soft"><span class="sun-dot"></span>Le salon en bref</div>
            <h2 class="has-accent-text">Les trois fonctions <strong>du SaLMeTE</strong></h2>
        </div>
        <div class="row g-5" data-reveal>
            @foreach ([
                ['Espace clé d\'orientation', 'Un cadre immersif pour découvrir concrètement les métiers du futur, tester des équipements en direct et échanger avec des centres de formation, des formateurs et des mentors.'],
                ['Vitrine « Go-To-Market »', 'Les jeunes innovateurs et artisans sortent de l\'isolement : démonstrations dynamiques « par le faire » pour prouver la fiabilité et la rentabilité de leurs technologies.'],
                ['Hub de maillage B2B', 'La connexion directe Formation – Entreprise – Territoire : contrats, stages, apprentissages et financement du passage à l\'échelle des innovations locales.'],
            ] as $function)
                <div class="col-md-4">
                    <div class="feature-col h-100">
                        <span class="feature-num">{{ $loop->iteration }}</span>
                        <h3>{{ $function[0] }}</h3>
                        <p class="mb-0">{{ $function[1] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================= INTRO + STATS --}}
<section class="section pt-0">
    <div class="container">
        <div class="row g-4 align-items-stretch" data-reveal>
            <div class="col-lg-6">
                <div class="card-feature-green h-100">
                    <span class="leaf leaf-gold"></span>
                    <div class="eyebrow"><span class="sun-dot"></span>Pourquoi le SaLMeTE</div>
                    <h3>Un carrefour des métiers techniques et écologiques</h3>
                    <p>{{ \App\Models\Setting::get('home_intro') }}</p>
                    <p class="mb-4">Organisé à Natitingou, capitale de l'Atacora, le salon connecte jeunes talents, artisans, centres de formation, entreprises et décideurs du territoire.</p>
                    <a href="{{ route('about') }}" class="btn btn-outline-light">En savoir plus sur le salon</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-3 h-100">
                    @foreach (['stat_participants' => 'bi-people', 'stat_exposants' => 'bi-shop', 'stat_partnerships' => 'bi-handshake', 'stat_youth' => 'bi-mortarboard', 'stat_awards' => 'bi-trophy'] as $key => $icon)
                        <div class="col-6 {{ $loop->last ? 'col-md-12' : 'col-md-6' }}">
                            <div class="stat-card d-flex flex-column justify-content-center {{ $loop->last ? 'stat-gold' : '' }}">
                                <i class="bi {{ $icon }} fs-4"></i>
                                <div class="stat-number mt-2">{{ \App\Models\Setting::get($key) }}</div>
                                <div class="stat-label">{{ \App\Models\Setting::get($key . '_label') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================= COMPOSANTES --}}
<section class="section odd-section">
    <div class="container">
        <div class="section-heading" data-reveal>
            <div class="eyebrow eyebrow-soft"><span class="sun-dot"></span>Programme</div>
            <h2 class="has-accent-text">Les 6 composantes <strong>du salon</strong></h2>
        </div>
        <div class="row g-4" data-reveal>
            @foreach ($components as $component)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 p-4">
                        <span class="icon-circle {{ $loop->even ? 'icon-circle-gold' : '' }} mb-4"><i class="bi {{ $component->icon }}"></i></span>
                        <h3 class="h5">{{ $component->title }}</h3>
                        <p class="text-muted mb-0">{{ $component->summary }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('program') }}" class="btn btn-outline-brand">Voir l'agenda détaillé</a>
        </div>
    </div>
</section>

{{-- ============================================================= GALERIE APERCU --}}
<section class="section pt-0">
    <div class="container">
        <div class="section-heading" data-reveal>
            <div class="eyebrow eyebrow-soft"><span class="sun-dot"></span>Galerie</div>
            <h2 class="has-accent-text">Retour <strong>en images</strong></h2>
        </div>
        <div class="row g-3" data-reveal>
            @foreach ($galleries as $photo)
                <div class="col-6 col-md-3">
                    <a href="{{ route('gallery') }}" class="gallery-item">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->image) }}" alt="{{ $photo->title }}" loading="lazy">
                        <span class="gallery-caption"><small>{{ $photo->category }}</small>{{ $photo->title }}</span>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('gallery') }}" class="btn btn-outline-brand">Toute la galerie</a>
        </div>
    </div>
</section>

{{-- ============================================================= CTA --}}
<section class="cta-section text-center">
    <div class="container" data-reveal>
        <h2 class="mb-4">Investissez dans l'avenir du territoire</h2>
        <div class="cta-checks mb-4">
            <span><i class="bi bi-check-lg"></i>Visibilité régionale et nationale</span>
            <span><i class="bi bi-check-lg"></i>Vivier de talents techniques</span>
        </div>
        <p class="lead mb-5">
            Devenez partenaire ou mécène du SaLMeTE 2026 : incarnez votre RSE et soutenez des innovations locales à fort impact.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('partners') }}#sponsoring" class="btn btn-gold btn-lg btn-has-icon">
                Devenir sponsor
                <span class="btn-icon"><i class="bi bi-arrow-up-right"></i></span>
            </a>
            <a href="{{ route('registrations.create') }}" class="btn btn-outline-light btn-lg">S'inscrire au salon</a>
        </div>
    </div>
</section>
@endsection
