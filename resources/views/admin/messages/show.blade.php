@extends('layouts.admin')

@section('title', 'Message')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">Message #{{ $message->id }}</h1>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour</a>
</div>

<div class="card">
    <div class="card-header bg-white d-flex flex-wrap justify-content-between gap-2">
        <div>
            <div class="fw-bold">{{ $message->subject ?: 'Message sans sujet' }}</div>
            <small class="text-muted">Reçu le {{ $message->created_at->format('d/m/Y à H:i') }}</small>
        </div>
        <form action="{{ route('admin.messages.toggleRead', $message) }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-check2-all me-1"></i>Marquer comme {{ $message->is_read ? 'non lu' : 'lu' }}
            </button>
        </form>
    </div>
    <div class="card-body">
        <dl class="row mb-3">
            <dt class="col-sm-3">Nom</dt>
            <dd class="col-sm-9">{{ $message->name }}</dd>
            <dt class="col-sm-3">E-mail</dt>
            <dd class="col-sm-9"><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd>
            <dt class="col-sm-3">Téléphone</dt>
            <dd class="col-sm-9">{{ $message->phone ?: '—' }}</dd>
        </dl>
        <div class="p-3 bg-light rounded">
            {!! nl2br(e($message->message)) !!}
        </div>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between">
        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
              onsubmit="return confirm('Supprimer ce message ?');">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>Supprimer</button>
        </form>
        <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('RE : ' . ($message->subject ?: 'Votre message au SaLMeTE')) }}"
           class="btn btn-brand btn-sm">
            <i class="bi bi-reply me-1"></i>Répondre
        </a>
    </div>
</div>
@endsection
