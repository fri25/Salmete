@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
@php
    $daysLeft = $eventStartsAt && $eventStartsAt->isFuture() ? (int) ceil(now()->floatDiffInDays($eventStartsAt)) : null;
    $participants = $registrationsByType['participant'] ?? 0;
    $exhibitors = $registrationsByType['exposant'] ?? 0;
@endphp

<div class="page-header">
    <div>
        <p class="page-kicker">{{ \Illuminate\Support\Str::ucfirst(now()->translatedFormat('l j F Y')) }}</p>
        <h1>Tableau de bord</h1>
    </div>
    @if ($daysLeft !== null)
        <div class="event-countdown">
            <span class="event-countdown-value">J-{{ $daysLeft }}</span>
            <span>avant l'ouverture<br><strong>{{ \Illuminate\Support\Str::ucfirst($eventStartsAt->translatedFormat('l j F')) }}</strong></span>
        </div>
    @endif
</div>

{{-- Indicateurs --}}
<div class="kpi-grid mb-4">
    <a href="{{ route('admin.inscriptions.index') }}" class="kpi">
        <span class="kpi-label">Inscriptions</span>
        <span class="kpi-value">{{ $counts['registrations'] }}</span>
        <span class="kpi-meta">{{ $participants }} participant{{ $participants > 1 ? 's' : '' }} · {{ $exhibitors }} exposant{{ $exhibitors > 1 ? 's' : '' }}</span>
    </a>
    <a href="{{ route('admin.inscriptions.index', ['status' => 'nouveau']) }}" class="kpi {{ $counts['newRegistrations'] ? 'kpi-alert' : '' }}">
        <span class="kpi-label">À traiter</span>
        <span class="kpi-value">{{ $counts['newRegistrations'] }}</span>
        <span class="kpi-meta">{{ $counts['newRegistrations'] ? 'Nouvelles demandes en attente' : 'Aucune demande en attente' }}</span>
    </a>
    <a href="{{ route('admin.messages.index') }}" class="kpi {{ $counts['unreadMessages'] ? 'kpi-alert' : '' }}">
        <span class="kpi-label">Messages non lus</span>
        <span class="kpi-value">{{ $counts['unreadMessages'] }}</span>
        <span class="kpi-meta">sur {{ $counts['messages'] }} reçu{{ $counts['messages'] > 1 ? 's' : '' }}</span>
    </a>
    <a href="{{ route('admin.partenaires.index') }}" class="kpi">
        <span class="kpi-label">Partenaires</span>
        <span class="kpi-value">{{ $counts['partners'] }}</span>
        <span class="kpi-meta">{{ $counts['offers'] }} formules de sponsoring</span>
    </a>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h2>Dernières inscriptions</h2>
                <a href="{{ route('admin.inscriptions.index') }}" class="link-more">Tout voir <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Demandeur</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th class="text-end">Reçue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestRegistrations as $registration)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.inscriptions.show', $registration) }}" class="fw-semibold">{{ $registration->full_name }}</a>
                                    @if ($registration->organization)
                                        <div class="small text-muted">{{ $registration->organization }}</div>
                                    @endif
                                </td>
                                <td>{{ \Illuminate\Support\Str::ucfirst($registration->type) }}</td>
                                <td><span class="badge bg-{{ $registration->statusBadge() }}">{{ \App\Models\Registration::STATUS[$registration->status] ?? $registration->status }}</span></td>
                                <td class="text-end small text-muted text-nowrap">{{ $registration->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">Aucune inscription pour le moment.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4 d-flex flex-column gap-4">
        <div class="card">
            <div class="card-header">
                <h2>Messages récents</h2>
                <a href="{{ route('admin.messages.index') }}" class="link-more">Tout voir <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="list-group list-group-flush">
                @forelse ($latestMessages as $message)
                    <a href="{{ route('admin.messages.show', $message) }}" class="list-group-item list-group-item-action message-item {{ $message->is_read ? '' : 'unread' }}">
                        <div class="d-flex justify-content-between gap-2">
                            <span class="message-from">{{ $message->name }}</span>
                            <small class="text-muted text-nowrap">{{ $message->created_at->diffForHumans(short: true) }}</small>
                        </div>
                        <div class="message-subject">{{ $message->subject ?: 'Sans objet' }}</div>
                    </a>
                @empty
                    <div class="empty-state">Aucun message reçu.</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h2>Suivi des inscriptions</h2></div>
            <div class="card-body">
                @php $totalRegistrations = max(1, $counts['registrations']); @endphp
                @foreach (\App\Models\Registration::STATUS as $status => $label)
                    @php $statusCount = $registrationsByStatus[$status] ?? 0; @endphp
                    <div class="status-row">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>{{ $label }}</span>
                            <span class="fw-semibold">{{ $statusCount }}</span>
                        </div>
                        <div class="progress" role="progressbar" aria-label="{{ $label }}" aria-valuenow="{{ $statusCount }}" aria-valuemin="0" aria-valuemax="{{ $counts['registrations'] }}">
                            <div class="progress-bar status-{{ $status }}" style="width: {{ round($statusCount / $totalRegistrations * 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h2>Contenu publié</h2></div>
            <div class="list-group list-group-flush content-list">
                @foreach ([
                    ['admin.composantes.index', 'Composantes du programme', $counts['components']],
                    ['admin.agenda.index', 'Créneaux d’agenda', $counts['schedule']],
                    ['admin.galerie.index', 'Photos de la galerie', $counts['galleries']],
                    ['admin.sponsoring.index', 'Formules de sponsoring', $counts['offers']],
                ] as [$contentRoute, $contentLabel, $contentCount])
                    <a href="{{ route($contentRoute) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        {{ $contentLabel }}
                        <span class="text-muted">{{ $contentCount }} <i class="bi bi-chevron-right ms-1 small"></i></span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
