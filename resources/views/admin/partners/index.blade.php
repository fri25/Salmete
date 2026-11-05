@extends('layouts.admin')

@section('title', 'Partenaires')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">Partenaires</h1>
    <a href="{{ route('admin.partenaires.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i>Ajouter</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th class="d-none d-lg-table-cell">Description</th>
                    <th>Visible</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($partners as $partner)
                    <tr>
                        <td>
                            @if ($partner->logo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($partner->logo) }}" alt="" style="width:52px;height:52px;object-fit:contain;">
                            @else
                                <span class="partner-initials" style="width:44px;height:44px;font-size:1rem;">{{ \Illuminate\Support\Str::of($partner->name)->substr(0, 2)->upper() }}</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $partner->name }}</td>
                        <td><span class="badge bg-info text-dark">{{ $partner->category }}</span></td>
                        <td class="d-none d-lg-table-cell small text-muted">{{ \Illuminate\Support\Str::limit($partner->description, 70) }}</td>
                        <td><span class="badge bg-{{ $partner->is_visible ? 'success' : 'secondary' }}">{{ $partner->is_visible ? 'Oui' : 'Non' }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.partenaires.edit', $partner) }}" class="btn btn-sm btn-outline-brand"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.partenaires.destroy', $partner) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce partenaire ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucun partenaire enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
