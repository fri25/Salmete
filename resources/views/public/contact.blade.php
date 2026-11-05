@extends('layouts.app')

@section('title', 'Contact')
@section('breadcrumb', 'Contact')
@section('page-title', 'Contactez l’organisation')
@section('page-subtitle', 'Une question sur le salon, les inscriptions ou le partenariat ? Écrivez-nous.')

@section('content')
@include('partials.page-hero')

<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <h2 class="section-title">Coordonnées</h2>
                <ul class="list-unstyled d-grid gap-4">
                    <li class="d-flex gap-3">
                        <span class="icon-circle flex-shrink-0"><i class="bi bi-building"></i></span>
                        <div>
                            <strong>Organisateur</strong>
                            <p class="text-muted mb-0">{{ \App\Models\Setting::get('contact_org') }}</p>
                        </div>
                    </li>
                    <li class="d-flex gap-3">
                        <span class="icon-circle flex-shrink-0"><i class="bi bi-geo-alt"></i></span>
                        <div>
                            <strong>Adresse</strong>
                            <p class="text-muted mb-0">{{ \App\Models\Setting::get('contact_address') }}</p>
                        </div>
                    </li>
                    <li class="d-flex gap-3">
                        <span class="icon-circle flex-shrink-0"><i class="bi bi-telephone"></i></span>
                        <div>
                            <strong>Téléphone / WhatsApp</strong>
                            <p class="text-muted mb-0">{{ \App\Models\Setting::get('contact_phone') }}</p>
                        </div>
                    </li>
                    <li class="d-flex gap-3">
                        <span class="icon-circle flex-shrink-0"><i class="bi bi-envelope"></i></span>
                        <div>
                            <strong>E-mail</strong>
                            <p class="mb-0"><a href="mailto:{{ \App\Models\Setting::get('contact_email') }}">{{ \App\Models\Setting::get('contact_email') }}</a></p>
                        </div>
                    </li>
                    <li class="d-flex gap-3">
                        <span class="icon-circle flex-shrink-0"><i class="bi bi-calendar-event"></i></span>
                        <div>
                            <strong>Dates de l'événement</strong>
                            <p class="text-muted mb-0">{{ \App\Models\Setting::get('event_dates') }}</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-7">
                <div class="card p-4 p-md-5">
                    <h2 class="h4 text-brand mb-4"><i class="bi bi-chat-dots me-2"></i>Envoyer un message</h2>
                    <form action="{{ route('contact.store') }}" method="POST" class="row g-3">
                        @csrf
                        @include('partials.honeypot')
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="subject" class="form-label">Sujet</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" placeholder="Ex : demande de partenariat">
                            @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-brand btn-lg"><i class="bi bi-send me-2"></i>Envoyer le message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
