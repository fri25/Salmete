@extends('layouts.admin')

@section('title', 'Paramètres')

@section('content')
<h1 class="h3 text-brand mb-4">Paramètres du site</h1>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Identité --}}
    <div class="card mb-4">
        <div class="card-header bg-white"><h2 class="h6 mb-0 text-brand"><i class="bi bi-badge-4k me-2"></i>Identité & accueil</h2></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nom du site</label>
                    <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings['site_name'] ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Slogan</label>
                    <input type="text" name="site_tagline" class="form-control" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mention d'édition</label>
                    <input type="text" name="site_edition" class="form-control" value="{{ old('site_edition', $settings['site_edition'] ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Logo du site</label>
                    <input type="file" name="site_logo" accept="image/png,image/jpeg,image/webp" class="form-control @error('site_logo') is-invalid @enderror">
                    @error('site_logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">PNG, JPEG ou WebP, 2 Mo maximum.</div>
                </div>
                @if (!empty($settings['site_logo']))
                    <div class="col-md-6">
                        <span class="form-label">Logo actuel</span>
                        <div class="border rounded p-2 bg-light d-inline-flex align-items-center justify-content-center" style="width:112px;height:112px;">
                            <img src="{{ Storage::disk('public')->url($settings['site_logo']) }}" alt="Logo actuel du site" style="max-width:96px;max-height:96px;object-fit:contain;">
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    <label class="form-label">Thème de l'édition (hero)</label>
                    <textarea name="hero_theme" rows="3" class="form-control">{{ old('hero_theme', $settings['hero_theme'] ?? '') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Dates</label>
                    <input type="text" name="event_dates" class="form-control" value="{{ old('event_dates', $settings['event_dates'] ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lieu</label>
                    <input type="text" name="event_location" class="form-control" value="{{ old('event_location', $settings['event_location'] ?? '') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Texte d'introduction (accueil)</label>
                    <textarea name="home_intro" rows="3" class="form-control">{{ old('home_intro', $settings['home_intro'] ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- Chiffres clés --}}
    <div class="card mb-4">
        <div class="card-header bg-white"><h2 class="h6 mb-0 text-brand"><i class="bi bi-bar-chart me-2"></i>Chiffres clés (accueil)</h2></div>
        <div class="card-body">
            <div class="row g-3">
                @foreach (['stat_participants' => 'Participants', 'stat_exposants' => 'Exposants', 'stat_partnerships' => 'Partenariats', 'stat_youth' => 'Jeunes formés', 'stat_awards' => 'Innovations primées'] as $key => $label)
                    <div class="col-md-3 col-6">
                        <label class="form-label small">{{ $label }} — valeur</label>
                        <input type="text" name="{{ $key }}" class="form-control" value="{{ old($key, $settings[$key] ?? '') }}">
                        <label class="form-label small mt-2">Libellé</label>
                        <input type="text" name="{{ $key }}_label" class="form-control" value="{{ old($key . '_label', $settings[$key . '_label'] ?? '') }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Contenu à propos --}}
    <div class="card mb-4">
        <div class="card-header bg-white"><h2 class="h6 mb-0 text-brand"><i class="bi bi-file-text me-2"></i>Page « À propos »</h2></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Contexte stratégique</label>
                    <textarea name="about_context" rows="6" class="form-control">{{ old('about_context', $settings['about_context'] ?? '') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Objectif général</label>
                    <textarea name="about_goal_general" rows="4" class="form-control">{{ old('about_goal_general', $settings['about_goal_general'] ?? '') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Objectif spécifique</label>
                    <textarea name="about_goal_specific" rows="4" class="form-control">{{ old('about_goal_specific', $settings['about_goal_specific'] ?? '') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Résultats attendus</label>
                    <textarea name="about_results" rows="4" class="form-control">{{ old('about_results', $settings['about_results'] ?? '') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Suivi & évaluation</label>
                    <textarea name="about_followup" rows="4" class="form-control">{{ old('about_followup', $settings['about_followup'] ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- Contact & réseaux --}}
    <div class="card mb-4">
        <div class="card-header bg-white"><h2 class="h6 mb-0 text-brand"><i class="bi bi-telephone me-2"></i>Contact & réseaux sociaux</h2></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Organisme</label>
                    <input type="text" name="contact_org" class="form-control" value="{{ old('contact_org', $settings['contact_org'] ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Adresse</label>
                    <input type="text" name="contact_address" class="form-control" value="{{ old('contact_address', $settings['contact_address'] ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mail de contact</label>
                    <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Facebook (URL)</label>
                    <input type="url" name="social_facebook" class="form-control" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">YouTube (URL)</label>
                    <input type="url" name="social_youtube" class="form-control" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">WhatsApp (numéro international)</label>
                    <input type="text" name="social_whatsapp" class="form-control" value="{{ old('social_whatsapp', $settings['social_whatsapp'] ?? '') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Texte du pied de page</label>
                    <textarea name="footer_about" rows="2" class="form-control">{{ old('footer_about', $settings['footer_about'] ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-brand btn-lg mb-4"><i class="bi bi-save me-2"></i>Enregistrer tous les paramètres</button>
</form>
@endsection
