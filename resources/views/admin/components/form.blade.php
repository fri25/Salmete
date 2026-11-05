@extends('layouts.admin')

@section('title', $component->exists ? 'Modifier une composante' : 'Nouvelle composante')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">{{ $component->exists ? 'Modifier la composante' : 'Nouvelle composante' }}</h1>
    <a href="{{ route('admin.composantes.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour</a>
</div>

<div class="card p-4">
    <form action="{{ $component->exists ? route('admin.composantes.update', $component) : route('admin.composantes.store') }}" method="POST">
        @csrf
        @if ($component->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $component->title) }}" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Icône Bootstrap <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text" id="iconPreview"><i class="bi {{ old('icon', $component->icon ?: 'bi-stars') }}"></i></span>
                    <input type="text" name="icon" id="iconInput" class="form-control @error('icon') is-invalid @enderror"
                           value="{{ old('icon', $component->icon) }}" placeholder="bi-stars" required>
                </div>
                <small class="text-muted">Référence sur icons.getbootstrap.com (ex. bi-trophy)</small>
                @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Résumé court <span class="text-danger">*</span></label>
                <input type="text" name="summary" maxlength="500" class="form-control @error('summary') is-invalid @enderror"
                       value="{{ old('summary', $component->summary) }}" required>
                @error('summary') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Description détaillée <span class="text-danger">*</span></label>
                <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $component->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Ordre d'affichage</label>
                <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $component->sort_order ?? 0) }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_visible" value="0">
                    <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" value="1"
                           @checked(old('is_visible', $component->is_visible ?? true))>
                    <label class="form-check-label" for="is_visible">Visible sur le site</label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-brand"><i class="bi bi-save me-1"></i>Enregistrer</button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const iconInput = document.getElementById('iconInput');
    const iconPreview = document.getElementById('iconPreview').querySelector('i');
    iconInput.addEventListener('input', () => {
        iconPreview.className = 'bi ' + iconInput.value;
    });
</script>
@endpush
@endsection
