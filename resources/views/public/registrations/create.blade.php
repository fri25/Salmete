@extends('layouts.app')

@section('title', 'Inscription')
@section('breadcrumb', 'Inscription')
@section('page-title', 'Inscription au SaLMeTE 2026')
@section('page-subtitle', 'Participant aux ateliers ou exposant / sponsor : choisissez votre profil')

@section('content')
@include('partials.page-hero')

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <ul class="nav nav-pills justify-content-center gap-2 mb-4" id="typePills" role="tablist">
                    @foreach ($types as $value => $label)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ old('type', request('type', 'participant')) === $value ? 'active bg-brand' : '' }}"
                                    data-type="{{ $value }}" type="button">
                                <i class="bi {{ $value === 'participant' ? 'bi-person-badge' : 'bi-shop-window' }} me-2"></i>{{ $label }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="card p-4 p-md-5">
                    <form action="{{ route('registrations.store') }}" method="POST" class="row g-3">
                        @csrf
                        @include('partials.honeypot')
                        <input type="hidden" name="type" id="typeInput" value="{{ old('type', request('type', 'participant')) }}">

                        <div class="col-12">
                            <div class="alert bg-brand-soft border-0 small mb-0">
                                <i class="bi bi-info-circle text-brand me-2"></i>
                                <span id="typeHelp">
                                    Inscription aux formations pratiques et au parcours d'orientation (3 jours) : de 2 000 FCFA (formation) à 30 000 FCFA (formation, t-shirt, attestation, hébergement et collation). La visite du salon est libre et gratuite.
                                </span>
                            </div>
                        </div>

                        @include('partials.registration-fields')
                    </form>
                </div>

                <div id="participantFees" class="mt-5 {{ old('type', request('type', 'participant')) === 'participant' ? '' : 'd-none' }}">
                    <h2 class="h5 text-center text-brand mb-3">Tarifs participants (3 jours)</h2>
                    @include('partials.participant-fees')
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    const helpTexts = {
        participant: "Inscription aux formations pratiques et au parcours d'orientation (3 jours) : de 2 000 FCFA (formation) à 30 000 FCFA (formation, t-shirt, attestation, hébergement et collation). La visite du salon est libre et gratuite.",
        exposant: "Demande de stand ou de sponsoring. Les tarifs des stands ne sont pas encore définis : l'organisation vous recontactera pour préciser la formule et les modalités d'aménagement."
    };

    document.querySelectorAll('#typePills .nav-link').forEach((pill) => {
        pill.addEventListener('click', () => {
            document.querySelectorAll('#typePills .nav-link').forEach((p) => p.classList.remove('active', 'bg-brand'));
            pill.classList.add('active', 'bg-brand');
            document.getElementById('typeInput').value = pill.dataset.type;
            document.getElementById('typeHelp').textContent = helpTexts[pill.dataset.type];
            document.getElementById('participantFees').classList.toggle('d-none', pill.dataset.type !== 'participant');
        });
    });
</script>
@endpush
@endsection
