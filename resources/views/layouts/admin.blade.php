<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Administration') — Admin SaLMeTE 2026</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @include('partials.favicon')
</head>
<body class="admin-body">
@php
    $newRegistrations = \App\Models\Registration::where('status', 'nouveau')->count();
    $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();
    $navGroups = [
        null => [
            ['route' => 'admin.dashboard', 'label' => 'Tableau de bord', 'icon' => 'bi-grid-1x2', 'active' => 'admin'],
        ],
        'Demandes' => [
            ['route' => 'admin.inscriptions.index', 'label' => 'Inscriptions', 'icon' => 'bi-person-check', 'active' => 'admin/inscriptions*', 'badge' => $newRegistrations],
            ['route' => 'admin.messages.index', 'label' => 'Messages', 'icon' => 'bi-inbox', 'active' => 'admin/messages*', 'badge' => $unreadMessages],
        ],
        'Contenu du site' => [
            ['route' => 'admin.composantes.index', 'label' => 'Composantes', 'icon' => 'bi-layers', 'active' => 'admin/composantes*'],
            ['route' => 'admin.agenda.index', 'label' => 'Agenda', 'icon' => 'bi-calendar3', 'active' => 'admin/agenda*'],
            ['route' => 'admin.partenaires.index', 'label' => 'Partenaires', 'icon' => 'bi-building', 'active' => 'admin/partenaires*'],
            ['route' => 'admin.sponsoring.index', 'label' => 'Sponsoring', 'icon' => 'bi-tag', 'active' => 'admin/sponsoring*'],
            ['route' => 'admin.galerie.index', 'label' => 'Galerie photos', 'icon' => 'bi-images', 'active' => 'admin/galerie*'],
        ],
        'Réglages' => [
            ['route' => 'admin.settings.edit', 'label' => 'Paramètres', 'icon' => 'bi-sliders', 'active' => 'admin/parametres*'],
        ],
    ];
    $userInitials = \Illuminate\Support\Str::of(auth()->user()->name)->explode(' ')->take(2)->map(fn ($word) => mb_substr($word, 0, 1))->implode('');
@endphp

<div class="admin-shell">
    {{-- Sidebar (offcanvas sous 992px) --}}
    <aside class="admin-sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="adminSidebar" aria-label="Navigation de l'administration">
        <div class="sidebar-head">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <img src="{{ asset('images/brand/logo-mark-white.svg') }}" alt="" width="30" height="36">
                <span>
                    <strong>SaLMeTE</strong>
                    <small>Administration · 2026</small>
                </span>
            </a>
            <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#adminSidebar" aria-label="Fermer le menu"></button>
        </div>

        <nav class="sidebar-nav">
            @foreach ($navGroups as $groupLabel => $items)
                @if ($groupLabel)
                    <div class="sidebar-group">{{ $groupLabel }}</div>
                @endif
                @foreach ($items as $item)
                    <a class="sidebar-link {{ request()->is($item['active']) ? 'active' : '' }}" href="{{ route($item['route']) }}"
                       @if (request()->is($item['active'])) aria-current="page" @endif>
                        <i class="bi {{ $item['icon'] }}"></i>
                        <span>{{ $item['label'] }}</span>
                        @if (! empty($item['badge']))
                            <span class="sidebar-count">{{ $item['badge'] }}</span>
                        @endif
                    </a>
                @endforeach
            @endforeach
        </nav>

        <div class="sidebar-foot">
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="sidebar-link">
                <i class="bi bi-box-arrow-up-right"></i><span>Voir le site public</span>
            </a>
        </div>
    </aside>

    {{-- Contenu --}}
    <div class="admin-main">
        <header class="admin-topbar">
            <button class="btn btn-icon d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar" aria-label="Ouvrir le menu">
                <i class="bi bi-list"></i>
            </button>
            <div class="topbar-title">@yield('title', 'Administration')</div>

            <div class="dropdown ms-auto">
                <button class="topbar-user" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="avatar">{{ $userInitials }}</span>
                    <span class="d-none d-sm-block text-start">
                        <span class="d-block fw-semibold">{{ auth()->user()->name }}</span>
                        <small class="d-block">{{ auth()->user()->email }}</small>
                    </span>
                    <i class="bi bi-chevron-down small"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('admin.settings.edit') }}"><i class="bi bi-sliders me-2"></i>Paramètres du site</a></li>
                    <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank" rel="noopener"><i class="bi bi-box-arrow-up-right me-2"></i>Voir le site public</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <main class="admin-content">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
