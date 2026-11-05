{{-- Grille des tarifs participants (formules valables pour les 3 jours du salon) --}}
<div class="row g-3 justify-content-center">
    @foreach ([
        [2000, ['Formation'], null],
        [5000, ['Formation', 'T-shirt'], null],
        [15000, ['Formation', 'T-shirt', 'Attestation', 'Collation'], null],
        [30000, ['Formation', 'T-shirt', 'Attestation', 'Hébergement', 'Collation'], 'Formule complète'],
    ] as [$fee, $includes, $badge])
        <div class="col-sm-6 col-lg-3">
            <div class="card pricing-card h-100 text-center {{ $badge ? 'featured' : '' }}">
                <div class="card-header-pricing">
                    @if ($badge)
                        <span class="badge bg-gold text-dark mb-2">{{ $badge }}</span>
                    @endif
                    <div class="price fs-4">{{ number_format($fee, 0, ',', ' ') }} FCFA</div>
                    <small class="text-muted">pour les 3 jours</small>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small d-grid gap-2 mb-0 text-start">
                        @foreach ($includes as $item)
                            <li><i class="bi bi-check-circle-fill text-brand me-2"></i>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>
<p class="text-center text-muted small mt-3 mb-0">
    <i class="bi bi-door-open me-1"></i>La visite du salon est <strong>libre et gratuite</strong>. Les tarifs ci-dessus concernent uniquement les participants aux formations.
</p>
