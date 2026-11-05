@extends('layouts.admin')

@section('title', 'Sponsoring')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">Formules de sponsoring</h1>
    <a href="{{ route('admin.sponsoring.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i>Ajouter</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Ordre</th>
                    <th>Formule</th>
                    <th>Public cible</th>
                    <th>Prix</th>
                    <th>Badge</th>
                    <th>Visible</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($offers as $offer)
                    <tr>
                        <td>{{ $offer->sort_order }}</td>
                        <td class="fw-semibold">{{ $offer->name }}</td>
                        <td class="small">{{ $offer->audience }}</td>
                        <td class="fw-semibold text-brand">
                            @if ($offer->price > 0)
                                {{ number_format($offer->price, 0, ',', ' ') }} FCFA
                            @else
                                <span class="text-muted">{{ $offer->price_note ?: 'Sur devis' }}</span>
                            @endif
                        </td>
                        <td>@if ($offer->badge)<span class="badge bg-warning text-dark">{{ $offer->badge }}</span>@endif</td>
                        <td><span class="badge bg-{{ $offer->is_visible ? 'success' : 'secondary' }}">{{ $offer->is_visible ? 'Oui' : 'Non' }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.sponsoring.edit', $offer) }}" class="btn btn-sm btn-outline-brand"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.sponsoring.destroy', $offer) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer cette formule ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Aucune formule enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
