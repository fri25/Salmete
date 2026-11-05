@extends('layouts.app')

@section('title', 'Programme')

@section('content')
{{-- ============================================================= HERO + COMPTE À REBOURS --}}
<section class="page-hero">
    <span class="leaf leaf-lime leaf-1"></span>
    <span class="leaf leaf-gold leaf-2"></span>
    <div class="container" data-reveal>
        <div class="eyebrow"><span class="sun-dot"></span>Programme</div>
        <h1 class="mb-0">
            @if ($schedule->isNotEmpty())
                Découvrez les {{ str_pad($schedule->count(), 2, '0', STR_PAD_LEFT) }} jours du SaLMeTE 2026
            @else
                Le programme du SaLMeTE 2026
            @endif
        </h1>
        <p class="mb-0 mt-3">{{ \App\Models\Setting::get('event_dates') }} · {{ \App\Models\Setting::get('event_location') }}</p>

        @if ($eventStartsAt)
            <div class="countdown" data-countdown="{{ $eventStartsAt->toIso8601String() }}" aria-label="Compte à rebours avant l'ouverture du salon">
                @foreach (['days' => 'Jours', 'hours' => 'Heures', 'minutes' => 'Minutes', 'seconds' => 'Secondes'] as $unit => $label)
                    <div class="countdown-item">
                        <span class="countdown-value" data-countdown-{{ $unit }}>00</span>
                        <span class="countdown-label">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ============================================================= AGENDA --}}
<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="program-intro" data-reveal>
                    <div class="eyebrow eyebrow-soft"><span class="sun-dot"></span>Agenda</div>
                    <h2 class="has-accent-text">Le programme du <strong>SaLMeTE 2026</strong></h2>
                    <p class="text-muted mt-3 mb-4">
                        Découvrez le programme officiel du salon et planifiez votre visite : des journées d'ateliers pratiques,
                        de démonstrations, de panels et de rencontres B2B, avec une approche immersive axée sur
                        « l'apprentissage par le faire ».
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#inscription" class="btn btn-brand btn-has-icon">
                            S'inscrire aux ateliers
                            <span class="btn-icon"><i class="bi bi-arrow-down-right"></i></span>
                        </a>
                        <a href="#composantes" class="btn btn-outline-brand">Les 6 composantes</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-reveal>
                @if ($schedule->isEmpty())
                    <p class="text-muted">L'agenda sera publié prochainement.</p>
                @else
                    <ul class="nav day-tabs" role="tablist">
                        @foreach ($schedule as $dayLabel => $items)
                            @php
                                [$dayName, $dayDate] = array_pad(explode(' — ', $dayLabel, 2), 2, '');
                            @endphp
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="day-tab-{{ $loop->index }}"
                                        data-bs-toggle="tab" data-bs-target="#day-pane-{{ $loop->index }}" type="button" role="tab"
                                        aria-controls="day-pane-{{ $loop->index }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    <span class="day-label">{{ $dayName }}</span>
                                    @if ($dayDate)
                                        <span class="day-date">{{ \Illuminate\Support\Str::ucfirst($dayDate) }}</span>
                                    @endif
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach ($schedule as $dayLabel => $items)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="day-pane-{{ $loop->index }}"
                                 role="tabpanel" aria-labelledby="day-tab-{{ $loop->index }}" tabindex="0">
                                <div class="agenda-list">
                                    @foreach ($items as $item)
                                        <div class="agenda-item">
                                            <div class="agenda-hour">{{ $item->time_range }}</div>
                                            <div class="agenda-activity">
                                                <h3>{{ $item->title }}</h3>
                                                @if ($item->description)
                                                    <p class="mb-1">{{ $item->description }}</p>
                                                @endif
                                                @if ($item->location)
                                                    <span class="agenda-place"><i class="bi bi-geo-alt me-1"></i>{{ $item->location }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ============================================================= COMPOSANTES --}}
<section class="section odd-section" id="composantes">
    <div class="container">
        <div class="section-heading" data-reveal>
            <div class="eyebrow eyebrow-soft"><span class="sun-dot"></span>Composantes</div>
            <h2 class="has-accent-text">Les 6 composantes <strong>opérationnelles</strong></h2>
        </div>
        <div class="row g-4" data-reveal>
            @foreach ($components as $component)
                <div class="col-lg-6">
                    <div class="card h-100 p-4">
                        <div class="d-flex gap-3">
                            <span class="icon-circle {{ $loop->even ? 'icon-circle-gold' : '' }} flex-shrink-0"><i class="bi {{ $component->icon }}"></i></span>
                            <div>
                                <h3 class="h5">{{ $component->title }}</h3>
                                <p class="text-muted mb-2">{{ $component->summary }}</p>
                                <p class="small text-muted mb-0">{!! nl2br(e($component->description)) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================= INSCRIPTION --}}
<section class="section" id="inscription">
    <div class="container">
        <div class="section-heading" data-reveal>
            <div class="eyebrow eyebrow-soft"><span class="sun-dot"></span>Inscription</div>
            <h2 class="has-accent-text">Réservez votre place <strong>aux ateliers</strong></h2>
            <p>Choisissez votre formule de participation pour les 3 jours. La visite du salon reste libre et gratuite.</p>
        </div>
        <div class="mb-5" data-reveal>
            @include('partials.participant-fees')
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card p-4 p-md-5" data-reveal>
                    <form action="{{ route('registrations.store') }}" method="POST" class="row g-3">
                        @csrf
                        @include('partials.honeypot')
                        <input type="hidden" name="type" value="participant">
                        @include('partials.registration-fields')
                    </form>
                </div>
                <p class="text-center small text-muted mt-3">
                    Les champs marqués d'un astérisque (<span class="text-danger">*</span>) sont obligatoires.
                    Exposant ou sponsor ? <a href="{{ route('registrations.create') }}?type=exposant" class="fw-semibold">Faites votre demande ici</a>.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
