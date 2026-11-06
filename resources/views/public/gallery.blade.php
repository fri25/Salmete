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
                    <a href="{{ \Illuminate\Support\Facades\Storage::url($photo->image) }}"
                       class="gallery-item"
                       data-bs-toggle="modal"
                       data-bs-target="#galleryLightbox"
                       data-full="{{ \Illuminate\Support\Facades\Storage::url($photo->image) }}"
                       data-title="{{ $photo->title }}"
                       data-category-label="{{ $photo->category }}"
                       aria-label="Agrandir : {{ $photo->title }}">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->image) }}" alt="{{ $photo->title }}" loading="lazy">
                        <span class="gallery-caption"><small>{{ $photo->category }}</small>{{ $photo->title }}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Visionneuse : navigation précédent / suivant, clavier (← → Échap), clic extérieur --}}
<div class="modal fade gallery-lightbox" id="galleryLightbox" tabindex="-1" aria-labelledby="galleryLightboxTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <button type="button" class="gallery-lightbox-close" data-bs-dismiss="modal" aria-label="Fermer la galerie">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>
            <button type="button" class="gallery-lightbox-nav gallery-lightbox-prev" data-gallery-prev aria-label="Image précédente">
                <i class="bi bi-chevron-left" aria-hidden="true"></i>
            </button>
            <img src="" alt="" id="galleryLightboxImage" class="gallery-lightbox-image">
            <button type="button" class="gallery-lightbox-nav gallery-lightbox-next" data-gallery-next aria-label="Image suivante">
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
            </button>
            <div class="gallery-lightbox-caption">
                <span class="gallery-lightbox-category" id="galleryLightboxCategory"></span>
                <span class="gallery-lightbox-title" id="galleryLightboxTitle"></span>
                <span class="gallery-lightbox-counter" id="galleryLightboxCounter" aria-live="polite"></span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Filtres par catégorie
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

    // Visionneuse : ne navigue que parmi les photos visibles (filtre actif)
    (() => {
        const lightbox = document.getElementById('galleryLightbox');
        if (!lightbox) return;

        const image = document.getElementById('galleryLightboxImage');
        const title = document.getElementById('galleryLightboxTitle');
        const category = document.getElementById('galleryLightboxCategory');
        const counter = document.getElementById('galleryLightboxCounter');

        let items = [];
        let current = 0;

        const visibleItems = () => Array.from(document.querySelectorAll('#galleryGrid .gallery-col'))
            .filter((col) => col.style.display !== 'none')
            .map((col) => col.querySelector('.gallery-item'))
            .filter(Boolean);

        const render = () => {
            const item = items[current];
            if (!item) return;

            image.src = item.dataset.full;
            image.alt = item.dataset.title || '';
            title.textContent = item.dataset.title || '';
            category.textContent = item.dataset.categoryLabel || '';
            counter.textContent = `${current + 1} / ${items.length}`;

            // Précharge les images voisines pour une navigation fluide.
            [items[current - 1], items[current + 1]].filter(Boolean).forEach((neighbor) => {
                const preload = new Image();
                preload.src = neighbor.dataset.full;
            });
        };

        const move = (step) => {
            if (!items.length) return;
            current = (current + step + items.length) % items.length;
            render();
        };

        lightbox.addEventListener('show.bs.modal', (event) => {
            items = visibleItems();
            current = Math.max(0, items.indexOf(event.relatedTarget));
            render();
        });

        lightbox.querySelector('[data-gallery-prev]').addEventListener('click', () => move(-1));
        lightbox.querySelector('[data-gallery-next]').addEventListener('click', () => move(1));

        document.addEventListener('keydown', (event) => {
            if (!lightbox.classList.contains('show')) return;

            if (event.key === 'ArrowLeft') {
                event.preventDefault();
                move(-1);
            } else if (event.key === 'ArrowRight') {
                event.preventDefault();
                move(1);
            }
        });
    })();
</script>
@endpush
@endsection
