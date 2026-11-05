@extends('layouts.admin')

@section('title', 'Galerie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">Galerie photos</h1>
    <a href="{{ route('admin.galerie.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i>Ajouter une photo</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-3">
            @forelse ($galleries as $photo)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->image) }}" class="card-img-top"
                             alt="{{ $photo->title }}" style="height:160px;object-fit:cover;">
                        <div class="card-body p-3">
                            <div class="fw-semibold text-truncate">{{ $photo->title }}</div>
                            <small class="text-muted">{{ $photo->category }} · ordre {{ $photo->sort_order }}</small>
                            <div class="mt-1">
                                <span class="badge bg-{{ $photo->is_visible ? 'success' : 'secondary' }}">
                                    {{ $photo->is_visible ? 'Visible' : 'Masquée' }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-white d-flex justify-content-between">
                            <a href="{{ route('admin.galerie.edit', $photo) }}" class="btn btn-sm btn-outline-brand"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.galerie.destroy', $photo) }}" method="POST"
                                  onsubmit="return confirm('Supprimer cette photo ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">Aucune photo dans la galerie.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
