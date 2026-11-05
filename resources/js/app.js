import * as bootstrap from 'bootstrap';

// Rendre Bootstrap accessible globalement si besoin (data-bs-* fonctionne déjà)
window.bootstrap = bootstrap;

// Auto-fermeture des alertes flash
setTimeout(() => {
    document.querySelectorAll('.alert-auto-dismiss').forEach((el) => {
        const alert = bootstrap.Alert.getOrCreateInstance(el);
        alert.close();
    });
}, 6000);

// Header flottant : se masque en descendant, réapparaît (compact) en remontant
const stickyHeader = document.querySelector('.sm-header');
if (stickyHeader) {
    let lastScrollY = window.scrollY;
    window.addEventListener('scroll', () => {
        const currentScrollY = window.scrollY;
        const menuIsOpen = stickyHeader.querySelector('.navbar-collapse.show');
        stickyHeader.classList.toggle('scroll-down', currentScrollY > lastScrollY && currentScrollY > 120 && !menuIsOpen);
        stickyHeader.classList.toggle('scroll-up', currentScrollY < lastScrollY && currentScrollY > 0);
        lastScrollY = currentScrollY;
    }, { passive: true });
}

// Titres animés : chaque mot apparaît avec un léger flou
document.querySelectorAll('[data-animated-text]').forEach((element) => {
    const baseDelay = parseFloat(element.dataset.delay || '0');
    const words = element.textContent.trim().split(/\s+/);
    element.textContent = '';
    words.forEach((word, index) => {
        const span = document.createElement('span');
        span.className = 'word';
        span.style.setProperty('--word-delay', `${baseDelay + index * 0.08}s`);
        span.textContent = word;
        element.append(span, ' ');
    });
    requestAnimationFrame(() => element.classList.add('is-visible'));
});

// Apparition des blocs au scroll
const revealElements = document.querySelectorAll('[data-reveal]');
if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    revealElements.forEach((element) => revealObserver.observe(element));
} else {
    revealElements.forEach((element) => element.classList.add('is-visible'));
}

// Compte à rebours avant l'ouverture du salon
document.querySelectorAll('[data-countdown]').forEach((countdown) => {
    const target = new Date(countdown.dataset.countdown).getTime();
    const pad = (value) => String(value).padStart(2, '0');

    const render = () => {
        const remaining = Math.max(0, target - Date.now());
        countdown.querySelector('[data-countdown-days]').textContent = pad(Math.floor(remaining / 86400000));
        countdown.querySelector('[data-countdown-hours]').textContent = pad(Math.floor(remaining / 3600000) % 24);
        countdown.querySelector('[data-countdown-minutes]').textContent = pad(Math.floor(remaining / 60000) % 60);
        countdown.querySelector('[data-countdown-seconds]').textContent = pad(Math.floor(remaining / 1000) % 60);

        return remaining;
    };

    if (render() > 0) {
        const timer = setInterval(() => {
            if (render() === 0) {
                clearInterval(timer);
            }
        }, 1000);
    }
});
