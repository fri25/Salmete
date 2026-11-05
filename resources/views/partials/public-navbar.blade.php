<header class="sm-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="{{ route('home') }}">
                @php
                    $siteLogo = \App\Models\Setting::get('site_logo');
                @endphp
                <img src="{{ $siteLogo ? Storage::disk('public')->url($siteLogo) : asset('images/brand/logo_home.svg') }}" alt="SaLMeTE — Salon Local des Métiers Techniques et Écologiques" class="brand-logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Menu de navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    @php
                        $links = [
                            ['route' => 'home', 'label' => 'Accueil'],
                            ['route' => 'about', 'label' => 'À propos'],
                            ['route' => 'program', 'label' => 'Programme'],
                            ['route' => 'exhibitors', 'label' => 'Exposants'],
                            ['route' => 'gallery', 'label' => 'Galerie'],
                            ['route' => 'partners', 'label' => 'Partenaires & sponsoring'],
                            ['route' => 'contact', 'label' => 'Contact'],
                        ];
                    @endphp
                    @foreach ($links as $link)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs($link['route']) ? 'active' : '' }}"
                               href="{{ route($link['route']) }}">{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a href="{{ route('registrations.create') }}" class="btn btn-gold">S'inscrire</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
