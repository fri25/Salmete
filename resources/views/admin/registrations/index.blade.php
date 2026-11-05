@extends('layouts.admin')

@section('title', 'Inscriptions')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h1 class="h3 text-brand mb-0">Inscriptions reçues <span class="text-muted fs-5">({{ $registrations->total() }})</span></h1>
    <a href="{{ route('admin.registrations.export') }}" class="btn btn-success btn-sm">
        <i class="bi bi-file-earmark-spreadsheet me-1"></i>Exporter en CSV
    </a>
</div>

<div class="card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small mb-1">Type</label>
                <select name="type" class="form-select form-select-sm">
                    <option value="">Tous les types</option>
                    @foreach ($types as $value => $label)
                        <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small mb-1">Statut</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Tous les statuts</option>
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-brand btn-sm"><i class="bi bi-funnel me-1"></i>Filtrer</button>
                <a href="{{ route('admin.inscriptions.index') }}" class="btn btn-outline-secondary btn-sm">Réinitialiser</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Demandeur</th>
                    <th>Type</th>
                    <th class="d-none d-lg-table-cell">Contact</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registrations as $registration)
                    <tr>
                        <td>
                            <a href="{{ route('admin.inscriptions.show', $registration) }}" class="fw-semibold text-decoration-none">
                                {{ $registration->full_name }}
                            </a>
                            @if ($registration->organization)
                                <div class="small text-muted">{{ $registration->organization }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $registration->type === 'exposant' ? 'bg-warning text-dark' : 'bg-success' }}">
                                {{ \Illuminate\Support\Str::ucfirst($registration->type) }}
                            </span>
                        </td>
                        <td class="d-none d-lg-table-cell small">
                            <div><i class="bi bi-envelope me-1"></i>{{ $registration->email }}</div>
                            <div class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $registration->phone }}</div>
                        </td>
                        <td><span class="badge bg-{{ $registration->statusBadge() }}">{{ $statuses[$registration->status] ?? $registration->status }}</span></td>
                        <td class="small text-muted">{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.inscriptions.show', $registration) }}" class="btn btn-sm btn-outline-brand">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucune inscription ne correspond à ces filtres.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($registrations->hasPages())
        <div class="card-footer">
            {{ $registrations->links() }}
        </div>
    @endif
</div>
@endsection
