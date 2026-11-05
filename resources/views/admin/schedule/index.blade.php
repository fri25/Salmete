@extends('layouts.admin')

@section('title', 'Agenda')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-brand mb-0">Agenda du salon</h1>
    <a href="{{ route('admin.agenda.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i>Ajouter un créneau</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Horaire</th>
                    <th>Session</th>
                    <th class="d-none d-md-table-cell">Lieu</th>
                    <th>Visible</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td class="text-nowrap small">
                            <div class="fw-semibold text-brand">{{ $item->day_label }}</div>
                            <div class="text-muted">{{ $item->day_date->format('d/m/Y') }}</div>
                        </td>
                        <td class="text-nowrap">{{ $item->time_range }}</td>
                        <td>
                            <div class="fw-semibold">{{ $item->title }}</div>
                            @if ($item->description)
                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($item->description, 80) }}</small>
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell small text-muted">{{ $item->location }}</td>
                        <td><span class="badge bg-{{ $item->is_visible ? 'success' : 'secondary' }}">{{ $item->is_visible ? 'Oui' : 'Non' }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.agenda.edit', $item) }}" class="btn btn-sm btn-outline-brand"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.agenda.destroy', $item) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce créneau ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucun créneau dans l’agenda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
