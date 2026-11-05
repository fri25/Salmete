@extends('layouts.admin')

@section('title', $item->exists ? 'Modifier un créneau' : 'Nouveau créneau')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">{{ $item->exists ? 'Modifier le créneau' : 'Nouveau créneau d’agenda' }}</h1>
    <a href="{{ route('admin.agenda.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour</a>
</div>

<div class="card p-4">
    <form action="{{ $item->exists ? route('admin.agenda.update', $item) : route('admin.agenda.store') }}" method="POST">
        @csrf
        @if ($item->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Libellé du jour <span class="text-danger">*</span></label>
                <input type="text" name="day_label" class="form-control @error('day_label') is-invalid @enderror"
                       value="{{ old('day_label', $item->day_label) }}" placeholder="Jour 1 — jeudi 19 novembre 2026" required>
                @error('day_label') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Date <span class="text-danger">*</span></label>
                <input type="date" name="day_date" class="form-control @error('day_date') is-invalid @enderror"
                       value="{{ old('day_date', optional($item->day_date)->format('Y-m-d')) }}" required>
                @error('day_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Heure de début <span class="text-danger">*</span></label>
                <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                       value="{{ old('start_time', $item->start_time) }}" required>
                @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Heure de fin</label>
                <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                       value="{{ old('end_time', $item->end_time) }}">
                @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Lieu</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $item->location) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Ordre</label>
                <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Titre de la session <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $item->title) }}" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control">{{ old('description', $item->description) }}</textarea>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_visible" value="0">
                    <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" value="1"
                           @checked(old('is_visible', $item->is_visible ?? true))>
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
