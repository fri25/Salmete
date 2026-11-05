@extends('layouts.app')

@section('title', 'Galerie')
@section('breadcrumb', 'Galerie')
@section('page-title', 'Galerie photos')
@section('page-subtitle', 'Retour en images sur la première édition du SaLMeTE')

@section('content')
@include('partials.page-hero')

<section class="section">
    <div class="container">
        <div class="d-flex flex-wrap gap-2 mb-4" id="galleryFilters">
            <button class="btn btn-brand btn-sm filter-btn active" data-filter="all">Toutes</button>
            @foreach ($categories as $category)
                <button class="btn btn-outline-brand btn-sm filter-btn" data-filter="{{ \Illuminate\Support\Str::slug($category) }}">{{ $category }}</button>
            @endforeach
        </div>

        <div class="row g-3" id="galleryGrid">
            @foreach ($galleries as $photo)
                <div class="col-6 col-md-4 col-lg-3 gallery-col" data-category="{{ \Illuminate\Support\Str::slug($photo->category) }}">
                    <a href="{{ \Illuminate\Support\Facades\Storage::url($photo->image) }}" target="_blank" rel="noopener" class="gallery-item">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->image) }}" alt="{{ $photo->title }}" loading="lazy">
                        <span class="gallery-caption"><small>{{ $photo->category }}</small>{{ $photo->title }}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.querySelectorAll('#galleryFilters .filter-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('#galleryFilters .filter-btn').forEach((b) => {
                b.classList.remove('active', 'btn-brand');
                b.classList.add('btn-outline-brand');
            });
            btn.classList.add('active', 'btn-brand');
            btn.classList.remove('btn-outline-brand');

            const filter = btn.dataset.filter;
            document.querySelectorAll('#galleryGrid .gallery-col').forEach((col) => {
                col.style.display = (filter === 'all' || col.dataset.category === filter) ? '' : 'none';
            });
        });
    });
</script>
@endpush
@endsection
