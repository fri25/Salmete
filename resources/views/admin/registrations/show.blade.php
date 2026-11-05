@extends('layouts.admin')

@section('title', 'Détail inscription')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">Inscription #{{ $registration->id }}</h1>
    <a href="{{ route('admin.inscriptions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour à la liste</a>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white">
                <span class="badge {{ $registration->type === 'exposant' ? 'bg-warning text-dark' : 'bg-success' }} fs-6">
                    {{ \App\Models\Registration::TYPES[$registration->type] ?? $registration->type }}
                </span>
                <span class="badge bg-{{ $registration->statusBadge() }} fs-6 ms-1">
                    {{ \App\Models\Registration::STATUS[$registration->status] ?? $registration->status }}
                </span>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nom complet</dt>
                    <dd class="col-sm-8">{{ $registration->full_name }}</dd>

                    <dt class="col-sm-4">Organisation</dt>
                    <dd class="col-sm-8">{{ $registration->organization ?: '—' }}</dd>

                    <dt class="col-sm-4">Profil</dt>
                    <dd class="col-sm-8">{{ $registration->profile ?: '—' }}</dd>

                    <dt class="col-sm-4">E-mail</dt>
                    <dd class="col-sm-8"><a href="mailto:{{ $registration->email }}">{{ $registration->email }}</a></dd>

                    <dt class="col-sm-4">Téléphone</dt>
                    <dd class="col-sm-8">
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $registration->phone) }}" target="_blank" rel="noopener">
                            {{ $registration->phone }}
                        </a>
                    </dd>

                    <dt class="col-sm-4">Message / motivation</dt>
                    <dd class="col-sm-8">{!! $registration->message ? nl2br(e($registration->message)) : '—' !!}</dd>

                    <dt class="col-sm-4">Reçue le</dt>
                    <dd class="col-sm-8">{{ $registration->created_at->format('d/m/Y à H:i') }}</dd>
                </dl>
            </div>
            <div class="card-footer bg-white d-flex justify-content-between">
                <form action="{{ route('admin.inscriptions.destroy', $registration) }}" method="POST"
                      onsubmit="return confirm('Supprimer définitivement cette inscription ?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>Supprimer</button>
                </form>
                <a href="mailto:{{ $registration->email }}" class="btn btn-brand btn-sm">
                    <i class="bi bi-reply me-1"></i>Répondre par e-mail
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-white"><h2 class="h6 mb-0 text-brand">Traitement de la demande</h2></div>
            <div class="card-body">
                <form action="{{ route('admin.inscriptions.status', $registration) }}" method="POST" class="d-grid gap-3">
                    @csrf
                    <div>
                        <label class="form-label fw-semibold">Changer le statut</label>
                        <select name="status" class="form-select">
                            @foreach (\App\Models\Registration::STATUS as $value => $label)
                                <option value="{{ $value }}" @selected($registration->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Note interne (non visible du demandeur)</label>
                        <textarea name="admin_note" rows="4" class="form-control">{{ old('admin_note', $registration->admin_note) }}</textarea>
                    </div>
                    <button class="btn btn-brand"><i class="bi bi-save me-1"></i>Enregistrer le suivi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
