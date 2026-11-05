@extends('layouts.admin')

@section('title', 'Composantes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">Composantes du programme</h1>
    <a href="{{ route('admin.composantes.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i>Ajouter</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:60px;">Ordre</th>
                    <th>Icône</th>
                    <th>Titre</th>
                    <th class="d-none d-lg-table-cell">Résumé</th>
                    <th>Visible</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($components as $component)
                    <tr>
                        <td>{{ $component->sort_order }}</td>
                        <td><i class="bi {{ $component->icon }} fs-4 text-brand"></i></td>
                        <td class="fw-semibold">{{ $component->title }}</td>
                        <td class="d-none d-lg-table-cell small text-muted">{{ \Illuminate\Support\Str::limit($component->summary, 90) }}</td>
                        <td>
                            <span class="badge bg-{{ $component->is_visible ? 'success' : 'secondary' }}">
                                {{ $component->is_visible ? 'Oui' : 'Non' }}
                            </span>
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.composantes.edit', $component) }}" class="btn btn-sm btn-outline-brand">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.composantes.destroy', $component) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer cette composante ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucune composante enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
