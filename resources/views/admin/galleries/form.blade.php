@extends('layouts.admin')

@section('title', $gallery->exists ? 'Modifier une photo' : 'Nouvelle photo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">{{ $gallery->exists ? 'Modifier la photo' : 'Ajouter une photo' }}</h1>
    <a href="{{ route('admin.galerie.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour</a>
</div>

<div class="card p-4">
    <form action="{{ $gallery->exists ? route('admin.galerie.update', $gallery) : route('admin.galerie.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if ($gallery->exists) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Titre / légende <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $gallery->title) }}" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Catégorie <span class="text-danger">*</span></label>
                <input type="text" name="category" list="galleryCategories" class="form-control @error('category') is-invalid @enderror"
                       value="{{ old('category', $gallery->category) }}" required>
                <datalist id="galleryCategories">
                    @foreach (\App\Models\Gallery::select('category')->distinct()->pluck('category') as $cat)
                        <option value="{{ $cat }}">
                    @endforeach
                </datalist>
                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    Fichier image (max 5 Mo) @if (! $gallery->exists)<span class="text-danger">*</span>@endif
                </label>
                <input type="file" name="image" accept="image/*"
                       class="form-control @error('image') is-invalid @enderror" {{ $gallery->exists ? '' : 'required' }}>
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @if ($gallery->exists)
                    <div class="mt-2">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($gallery->image) }}" alt="Image actuelle"
                             style="max-height:140px;object-fit:cover;" class="border rounded p-1 bg-white">
                        <small class="d-block text-muted">Image actuelle — laissez le champ vide pour la conserver.</small>
                    </div>
                @endif
            </div>
            <div class="col-md-3">
                <label class="form-label">Ordre</label>
                <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $gallery->sort_order ?? 0) }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_visible" value="0">
                    <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" value="1"
                           @checked(old('is_visible', $gallery->is_visible ?? true))>
                    <label class="form-check-label" for="is_visible">Visible</label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-brand"><i class="bi bi-save me-1"></i>Enregistrer</button>
            </div>
        </div>
    </form>
</div>
@endsection
