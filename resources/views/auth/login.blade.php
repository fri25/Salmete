<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion admin — {{ \App\Models\Setting::get('site_name') }}</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/brand/logo-mark.svg') }}">
</head>
<body class="admin-body admin-login">
    <div class="login-shell">
        <aside class="login-visual">
            <img src="{{ asset('images/brand/illustration.webp') }}" alt="" class="login-visual-img">
            <div class="login-visual-caption">
                <img src="{{ asset('images/brand/logo-mark-white.svg') }}" alt="" width="40" height="48">
                <div>
                    <strong>SaLMeTE 2026</strong>
                    <span>{{ \App\Models\Setting::get('event_dates') }} · Natitingou</span>
                </div>
            </div>
        </aside>

        <main class="login-panel">
            <div class="login-box">
                <img src="{{ asset('images/brand/logo-mark.svg') }}" alt="Logo SaLMeTE" width="40" height="48" class="mb-4">
                <h1>Connexion</h1>
                <p class="text-muted mb-4">Espace d'administration du Salon Local des Métiers Techniques et Écologiques.</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small" role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="d-grid gap-3">
                    @csrf
                    <div>
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-control" autocomplete="username" required autofocus>
                    </div>
                    <div>
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                        <label class="form-check-label" for="remember">Rester connecté</label>
                    </div>
                    <button type="submit" class="btn btn-brand w-100 mt-1">Se connecter</button>
                </form>

                <a href="{{ route('home') }}" class="login-back"><i class="bi bi-arrow-left me-1"></i>Retour au site public</a>
            </div>
        </main>
    </div>
</body>
</html>
