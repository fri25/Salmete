@extends('layouts.admin')

@section('title', $offer->exists ? 'Modifier une formule' : 'Nouvelle formule')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">{{ $offer->exists ? 'Modifier la formule' : 'Nouvelle formule de sponsoring' }}</h1>
    <a href="{{ route('admin.sponsoring.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour</a>
</div>

<div class="card p-4">
    <form action="{{ $offer->exists ? route('admin.sponsoring.update', $offer) : route('admin.sponsoring.store') }}" method="POST">
        @csrf
        @if ($offer->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-md-7">
                <label class="form-label">Nom de la formule <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $offer->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-5">
                <label class="form-label">Public cible</label>
                <input type="text" name="audience" class="form-control" value="{{ old('audience', $offer->audience) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Prix (FCFA, 0 = sur devis)</label>
                <input type="number" min="0" name="price" class="form-control" value="{{ old('price', $offer->price ?? 0) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Précision de prix</label>
                <input type="text" name="price_note" class="form-control" value="{{ old('price_note', $offer->price_note) }}" placeholder="/ jeune, sur devis...">
            </div>
            <div class="col-md-4">
                <label class="form-label">Badge (optionnel)</label>
                <input type="text" name="badge" class="form-control" value="{{ old('badge', $offer->badge) }}" placeholder="Tarif solidaire">
            </div>
            <div class="col-12">
                <label class="form-label">Description courte</label>
                <textarea name="description" rows="2" class="form-control">{{ old('description', $offer->description) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Caractéristiques (une par ligne)</label>
                <textarea name="features" rows="5" class="form-control" placeholder="Stand aménagé sur les 3 jours&#10;Visibilité sur les supports...">{{ old('features', $offer->features) }}</textarea>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ordre</label>
                <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $offer->sort_order ?? 0) }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_visible" value="0">
                    <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" value="1"
                           @checked(old('is_visible', $offer->is_visible ?? true))>
                    <label class="form-check-label" for="is_visible">Visible sur le site</label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-brand"><i class="bi bi-save me-1"></i>Enregistrer</button>
            </div>
        </div>
    </form>
</div>
@endsection
