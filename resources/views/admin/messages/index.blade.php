@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
<h1 class="h3 text-brand mb-4">Messages de contact <span class="text-muted fs-5">({{ $messages->total() }})</span></h1>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>État</th>
                    <th>Expéditeur</th>
                    <th>Sujet</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                    <tr class="{{ $message->is_read ? '' : 'table-light' }}">
                        <td>
                            @if ($message->is_read)
                                <span class="badge bg-secondary">Lu</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="bi bi-envelope-fill me-1"></i>Non lu</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold {{ $message->is_read ? '' : 'text-brand' }}">{{ $message->name }}</div>
                            <small class="text-muted">{{ $message->email }}</small>
                        </td>
                        <td>{{ $message->subject ?: '—' }}</td>
                        <td class="small text-muted">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-outline-brand"><i class="bi bi-eye"></i></a>
                            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce message ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Aucun message reçu.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($messages->hasPages())
        <div class="card-footer">{{ $messages->links() }}</div>
    @endif
</div>
@endsection
