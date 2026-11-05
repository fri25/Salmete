# SaLMeTE 2026 — Site web officiel

Site web du **Salon Local des Métiers Techniques et Écologiques (SaLMeTE)**, deuxième édition,
qui se tiendra **du 19 au 21 novembre 2026 à Natitingou (Atacora, Bénin)**.

Le site comprend un espace vitrine public complet et un **espace d'administration sécurisé**
permettant de gérer l'intégralité des contenus sans toucher au code.

## Stack technique

| Couche | Technologie |
|---|---|
| Framework back | **Laravel 13** (PHP 8.4) |
| Base de données | **MySQL / MariaDB** |
| Front | **Bootstrap 5.3** + Bootstrap Icons, compilés avec **Vite** et **Sass** |
| Vues | Blade (layouts, composants, pagination) |
| Authentification | Auth Laravel + middleware administrateur |

## Fonctionnalités

### Site public
- **Accueil** : hero avec thème officiel, chiffres clés, 3 missions, 6 composantes, aperçu agenda, galerie, partenaires, appels à l'action.
- **À propos** : contexte stratégique, objectifs général/spécifique, alignement ODD (4, 8, 9, 13), résultats attendus, suivi-évaluation, affiche officielle.
- **Programme** : les 6 composantes détaillées + agenda complet des 3 jours (15 créneaux).
- **Exposants** : avantages des stands, services subventionnés, tarifs.
- **Galerie photos** : 32 photos réelles de la première édition, filtrables par catégorie.
- **Partenaires** : 26 organisations classées par catégories (ONG, bailleurs, institutions, centres de formation…).
- **Sponsoring / mécénat** : les 7 formules de soutien avec tarifs FCFA et avantages.
- **Inscription en ligne** : formulaire à onglets *Participant* / *Exposant* avec validation et consentement.
- **Contact** : formulaire de message + coordonnées et réseaux sociaux.
- Design **responsive** (mobile, tablette, desktop) et références d'icônes Bootstrap.

### Espace administrateur (`/admin`)
- **Tableau de bord** : compteurs, nouvelles inscriptions, messages non lus, dernières demandes.
- **Composantes** : CRUD complet avec sélecteur d'icône en direct.
- **Agenda** : CRUD des créneaux (jour, dates, horaires, lieu, visibilité).
- **Partenaires** : CRUD avec upload de logo, catégories, liens web.
- **Sponsoring** : CRUD des formules (prix, note, badge, avantages multi-lignes).
- **Galerie photos** : CRUD avec upload d'images, catégories, ordre, visibilité.
- **Inscriptions** : liste filtrable (type/statut), fiche détaillée, suivi de statut (nouveau, en cours, acceptée, refusée), notes internes, lien WhatsApp, **export CSV**.
- **Messages de contact** : lecture, marque lu/non lu, réponse mail, suppression.
- **Paramètres** : identité du site, thème, dates/lieu, textes de la page À propos, chiffres clés, contact et réseaux sociaux.

## Prérequis

- PHP ≥ 8.3 (extensions : `pdo_mysql, mbstring, openssl, tokenizer, xml, ctype, json, bcmath, intl, gd, zip`)
- Composer 2
- MySQL ≥ 8 ou MariaDB ≥ 10.6
- Node.js ≥ 20 et npm
- Un serveur web (Apache/Nginx) ou le serveur intégré Laravel

## Installation

```bash
# 1. Récupérer les dépendances PHP
composer install

# 2. Préparer la configuration d'environnement
cp .env.example .env
php artisan key:generate

# 3. Créer la base MySQL (adapter les identifiants dans .env)
#    DB_DATABASE=salmete / DB_USERNAME=salmete / DB_PASSWORD=<mot de passe fort>
mysql -u root -p -e "CREATE DATABASE salmete CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                     CREATE USER 'salmete'@'localhost' IDENTIFIED BY '<mot de passe fort>';
                     GRANT ALL PRIVILEGES ON salmete.* TO 'salmete'@'localhost';
                     FLUSH PRIVILEGES;"

# 4. Exécuter migrations et données initiales
php artisan migrate:fresh --seed

# 5. Lier le stockage public (images de la galerie, logos)
php artisan storage:link

# 6. Installer et compiler les assets Bootstrap
npm install --legacy-peer-deps
npm run build        # production
# ou npm run dev     # mode développement avec rechargement automatique

# 7. Lancer l'application
php artisan serve
# puis ouvrir http://localhost:8000
```

## Compte administrateur par défaut

Créé par le seeder à partir des variables `ADMIN_EMAIL` et `ADMIN_PASSWORD` du fichier `.env`.
Si `ADMIN_PASSWORD` est vide, un mot de passe aléatoire est généré et affiché **une seule fois**
dans la console lors du `db:seed`. Un compte existant n'est jamais écrasé par le seeder.

URL de connexion : `http://localhost:8000/login`

## Modèle de données

`users` (admin) · `settings` (clés/valeurs) · `program_components` · `schedule_items` ·
`partners` · `sponsor_offers` · `galleries` · `registrations` · `contact_messages`
(+ tables système `cache`, `jobs`, `sessions`).

## Arborescence principale

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/           # 9 contrôleurs de l'espace admin
│   │   ├── Auth/            # connexion / déconnexion
│   │   ├── HomeController.php
│   │   ├── PageController.php
│   │   ├── RegistrationController.php
│   │   └── ContactController.php
│   └── Middleware/EnsureAdmin.php
├── Models/                  # 8 modèles métier + User
database/
├── migrations/              # 10 migrations
└── seeders/DatabaseSeeder.php  # tout le contenu initial (textes officiels du PDF)
resources/
├── scss/app.scss            # thème Bootstrap personnalisé (charte verte & or SaLMeTE)
├── js/app.js                # Bootstrap JS
└── views/
    ├── public/              # pages du site vitrine
    ├── admin/               # écrans d'administration
    ├── auth/login.blade.php
    └── layouts/             # layouts public et admin
public/images/brand/         # affiche officielle + image du hero
storage/app/public/gallery/  # 32 photos de la galerie
```

## Réinitialiser les données de démonstration

```bash
php artisan migrate:fresh --seed   # rejoue migrations + seeder (ATTENTION : vide les tables)
```

## Notes de mise en production

- Renseigner des identifiants MySQL forts et passer `APP_ENV=production`, `APP_DEBUG=false`.
- Modifier le mot de passe administrateur dès la première connexion.
- Configurer un vrai serveur SMTP dans `.env` pour l'envoi d'e-mails (les formulaires
  enregistrent déjà les demandes en base ; l'envoi mail peut être branché en complément).
- Servir les fichiers compilés de `public/build/` via Apache/Nginx avec `public/` comme racine web.
