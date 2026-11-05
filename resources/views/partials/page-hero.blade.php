<section class="page-hero">
    <span class="leaf leaf-lime leaf-1"></span>
    <span class="leaf leaf-gold leaf-2"></span>
    <div class="container" data-reveal>
        <div class="eyebrow"><span class="sun-dot"></span>@yield('breadcrumb', 'SaLMeTE 2026')</div>
        <h1 class="mb-0">@yield('page-title', $title ?? '')</h1>
        @hasSection('page-subtitle')
            <p class="mb-0 mt-3">@yield('page-subtitle')</p>
        @endif
    </div>
</section>
