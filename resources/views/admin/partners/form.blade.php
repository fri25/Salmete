@extends('layouts.admin')

@section('title', $partner->exists ? 'Modifier un partenaire' : 'Nouveau partenaire')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">{{ $partner->exists ? 'Modifier le partenaire' : 'Nouveau partenaire' }}</h1>
    <a href="{{ route('admin.partenaires.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour</a>
</div>

<div class="card p-4">
    <form action="{{ $partner->exists ? route('admin.partenaires.update', $partner) : route('admin.partenaires.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if ($partner->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nom <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $partner->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Catégorie <span class="text-danger">*</span></label>
                <input type="text" name="category" list="partnerCategories" class="form-control @error('category') is-invalid @enderror"
                       value="{{ old('category', $partner->category) }}" required>
                <datalist id="partnerCategories">
                    @foreach (\App\Models\Partner::select('category')->distinct()->pluck('category') as $cat)
                        <option value="{{ $cat }}">
                    @endforeach
                </datalist>
                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-control">{{ old('description', $partner->description) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Logo (image, max 3 Mo)</label>
                <input type="file" name="logo" accept="image/*" class="form-control @error('logo') is-invalid @enderror">
                @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @if ($partner->logo)
                    <div class="mt-2">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($partner->logo) }}" alt="Logo actuel"
                             style="max-height:80px;max-width:100%;object-fit:contain;" class="border rounded p-1 bg-white">
                        <small class="d-block text-muted">Logo actuel — laissez vide pour le conserver.</small>
                    </div>
                @endif
            </div>
            <div class="col-md-3">
                <label class="form-label">Site web</label>
                <input type="url" name="url" class="form-control" value="{{ old('url', $partner->url) }}" placeholder="https://">
            </div>
            <div class="col-md-3">
                <label class="form-label">Ordre</label>
                <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $partner->sort_order ?? 0) }}">
            </div>
            <div class="col-12 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_visible" value="0">
                    <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" value="1"
                           @checked(old('is_visible', $partner->is_visible ?? true))>
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
