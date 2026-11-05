<footer class="site-footer">
    <span class="leaf leaf-white leaf-1"></span>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('home') }}" class="footer-brand mb-3">
                    <img src="{{ asset('images/brand/logo_footer.png') }}" alt="SaLMeTE — Salon Local des Métiers Techniques et Écologiques">
                </a>
                <p class="mb-4">{{ \App\Models\Setting::get('footer_about') }}</p>
                <div>
                    @if ($fb = \App\Models\Setting::get('social_facebook'))
                        <a href="{{ $fb }}" target="_blank" rel="noopener" class="social-icon" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if ($yt = \App\Models\Setting::get('social_youtube'))
                        <a href="{{ $yt }}" target="_blank" rel="noopener" class="social-icon" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    @endif
                    @if ($wa = \App\Models\Setting::get('social_whatsapp'))
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $wa) }}" target="_blank" rel="noopener" class="social-icon" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    @endif
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <h6>Le salon</h6>
                <ul class="list-unstyled d-grid gap-2">
                    <li><a href="{{ route('about') }}">À propos</a></li>
                    <li><a href="{{ route('program') }}">Programme</a></li>
                    <li><a href="{{ route('exhibitors') }}">Devenir exposant</a></li>
                    <li><a href="{{ route('gallery') }}">Galerie photos</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6>Participer</h6>
                <ul class="list-unstyled d-grid gap-2">
                    <li><a href="{{ route('registrations.create') }}">Inscription participant</a></li>
                    <li><a href="{{ route('partners') }}">Nos partenaires</a></li>
                    <li><a href="{{ route('partners') }}#sponsoring">Sponsoring & mécénat</a></li>
                    <li><a href="{{ route('contact') }}">Nous contacter</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6>Contact</h6>
                <ul class="list-unstyled d-grid gap-2">
                    <li><i class="bi bi-building me-2"></i>{{ \App\Models\Setting::get('contact_org') }}</li>
                    <li><i class="bi bi-geo-alt me-2"></i>{{ \App\Models\Setting::get('contact_address') }}</li>
                    <li><i class="bi bi-telephone me-2"></i>{{ \App\Models\Setting::get('contact_phone') }}</li>
                    <li><i class="bi bi-envelope me-2"></i><a href="mailto:{{ \App\Models\Setting::get('contact_email') }}">{{ \App\Models\Setting::get('contact_email') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <span>© {{ date('Y') }} {{ \App\Models\Setting::get('site_name') }} — Tous droits réservés.</span>
            <span class="small">
                {{ \App\Models\Setting::get('event_dates') }} · {{ \App\Models\Setting::get('event_location') }}
                · <a href="{{ route('login') }}"><i class="bi bi-shield-lock me-1"></i>Espace admin</a>
            </span>
        </div>
    </div>
</footer>
