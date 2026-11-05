<div class="col-md-6">
    <label for="full_name" class="form-label">Nom complet <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
    @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="col-md-6">
    <label for="organization" class="form-label">Organisation / école / coopérative</label>
    <input type="text" class="form-control @error('organization') is-invalid @enderror" id="organization" name="organization" value="{{ old('organization') }}">
    @error('organization') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="col-md-6">
    <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="col-md-6">
    <label for="phone" class="form-label">Téléphone <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+229 ..." required>
    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="col-md-12">
    <label for="profile" class="form-label">Votre profil</label>
    <select class="form-select @error('profile') is-invalid @enderror" id="profile" name="profile">
        <option value="">— Sélectionner —</option>
        @foreach (['Élève / étudiant', 'Jeune entrepreneur', 'Artisan', 'Représentant d’ONG', 'Centre de formation / école', 'Institution / administration', 'Entreprise verte', 'Autre'] as $profile)
            <option value="{{ $profile }}" @selected(old('profile') === $profile)>{{ $profile }}</option>
        @endforeach
    </select>
    @error('profile') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="col-12">
    <label for="message" class="form-label">Motivation / précisions</label>
    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5"
              placeholder="Décrivez votre attente : atelier souhaité, technologie à exposer, stand demandé...">{{ old('message') }}</textarea>
    @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="col-12">
    <div class="form-check">
        <input class="form-check-input @error('rgpd') is-invalid @enderror" type="checkbox" value="1" id="rgpd" name="rgpd" @checked(old('rgpd')) required>
        <label class="form-check-label small" for="rgpd">
            J'accepte d'être recontacté(e) par l'organisation du SaLMeTE au sujet de mon inscription. <span class="text-danger">*</span>
        </label>
        @error('rgpd') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="col-12">
    <button type="submit" class="btn btn-brand btn-lg">
        <i class="bi bi-send-check me-2"></i>Envoyer mon inscription
    </button>
</div>
