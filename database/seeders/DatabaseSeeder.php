<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\Partner;
use App\Models\ProgramComponent;
use App\Models\Registration;
use App\Models\ScheduleItem;
use App\Models\Setting;
use App\Models\SponsorOffer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Carbon::setLocale('fr');

        // ------------------------------------------------------------------
        // Compte administrateur
        // ------------------------------------------------------------------
        $this->seedAdministrator();

        // ------------------------------------------------------------------
        // Paramètres généraux du site
        // ------------------------------------------------------------------
        $settings = [
            'site_name' => 'SaLMeTE 2026',
            'site_tagline' => 'Salon Local des Métiers Techniques et Écologiques',
            'site_edition' => 'Deuxième édition — Natitingou',
            'hero_theme' => "Jeunesse, Agriculture Durable et Artisanat Vert : valoriser les compétences et les innovations techniques au service de la résilience climatique et de l'emploi local.",
            'event_dates' => 'Du 19 au 21 novembre 2026',
            'event_location' => 'Natitingou, département de l’Atacora — Bénin',
            'home_intro' => "Le SaLMeTE est le carrefour décisionnel et économique des métiers techniques et écologiques de l'Atacora : un espace d'orientation pour les jeunes, une vitrine commerciale pour les artisans innovateurs et un hub de maillage B2B entre formation, entreprise et territoire.",
            'about_context' => "Le Bénin traverse une mutation profonde de son paysage socio-économique : plus de 60 % de la population a moins de 25 ans et près de 300 000 jeunes rejoignent chaque année le marché du travail, alors que le sous-emploi touche plus de 40 % des jeunes actifs. À travers la Stratégie Nationale de l'Enseignement et de la Formation Techniques et Professionnels (SN-EFTP 2020–2030), le Bénin replace les métiers manuels et industriels comme des choix d'avenir stratégiques.\n\nDans l'Atacora, région exposée aux chocs climatiques, à l'épuisement des sols et à la déforestation, deux défis demeurent : un déficit critique d'orientation vers les filières porteuses, et un blocage dans la commercialisation des innovations conçues par les artisans et jeunes diplômés (séchoirs solaires, foyers améliorés, biogaz domestique, outillage agricole), qui restent confinées au stade de prototypes.\n\nC'est pour répondre à cette double problématique qu'est organisée la deuxième édition du Salon Local des Métiers Techniques et Écologiques (SaLMeTE 2026) à Natitingou.",
            'about_goal_general' => "Promouvoir l'artisanat vert, l'agriculture durable et les métiers techniques auprès des jeunes comme leviers d'innovation, d'emploi local et de résilience climatique dans l'Atacora.",
            'about_goal_specific' => "Créer un cadre opérationnel d'orientation, de démonstration et de maillage B2B permettant de transformer les innovations technologiques locales en produits accessibles, vendables et créateurs d'opportunités d'insertion socioprofessionnelle.",
            'about_results' => "200 participants mobilisés, dont 50 jeunes et femmes formés à la pratique ; 10 à 15 exposants présentant leurs technologies ; au moins 10 partenariats formalisés ; 50 jeunes orientés vers des stages, apprentissages ou parcours d'incubation ; 3 innovations locales à fort impact primées et accompagnées vers le passage à l'échelle.",
            'about_followup' => "Mesure de satisfaction à chaud auprès des exposants, jeunes, entreprises et visiteurs ; rapport stratégique et capitalisation post-événement ; tracker d'opportunités à 6 mois pour concrétiser stages, contrats d'apprentissage, embauches, partenariats B2B et amorçage d'entreprises vertes.",
            'stat_participants' => '200',
            'stat_participants_label' => 'Participants mobilisés',
            'stat_exposants' => '15',
            'stat_exposants_label' => 'Exposants & démonstrateurs',
            'stat_partnerships' => '10',
            'stat_partnerships_label' => 'Partenariats visés',
            'stat_youth' => '50',
            'stat_youth_label' => 'Jeunes formés & orientés',
            'stat_awards' => '3',
            'stat_awards_label' => 'Innovations primées',
            'contact_org' => 'REJEVE Bénin — Réseau des Jeunes pour l’Économie Verte',
            'contact_email' => 'heviefoadrien@gmail.com',
            'contact_phone' => '+229 01 67 21 33 45',
            'contact_address' => 'Natitingou, Atacora, République du Bénin',
            'social_facebook' => 'https://facebook.com',
            'social_youtube' => 'https://www.youtube.com',
            'social_whatsapp' => '2290167213345',
            'footer_about' => "Le SaLMeTE est organisé par REJEVE Bénin avec l'appui de ses partenaires techniques et financiers, pour la promotion de l'artisanat vert, de l'agriculture durable et des métiers techniques dans l'Atacora.",
        ];

        foreach ($settings as $key => $value) {
            Setting::put($key, $value);
        }

        // ------------------------------------------------------------------
        // Les 6 composantes du salon
        // ------------------------------------------------------------------
        $components = [
            [
                'title' => 'Parcours d’orientation & immersion technologique (Minibus Écoles)',
                'icon' => 'bi-bus-front',
                'summary' => 'Des navettes acheminent quotidiennement élèves et apprentis sur les stands pour un parcours guidé des métiers porteurs.',
                'description' => "Des navettes en minibus sont organisées pour acheminer chaque jour des groupes d'élèves des collèges, lycées techniques et centres de formation de Natitingou et des communes environnantes. Accueillis par des guides-animateurs, les élèves effectuent un parcours guidé des stands, testent des équipements en direct (kits solaires, diagnostic mécanique, foyers améliorés) et échangent avec des formateurs et mentors pour affiner leur choix d'orientation professionnelle.",
            ],
            [
                'title' => 'Foire d’exposition, démonstrations pratiques & services subventionnés',
                'icon' => 'bi-shop-window',
                'summary' => '10 à 15 exposants présentent leurs technologies avec des démonstrations dynamiques en continu et des services à coût réduit.',
                'description' => "Un espace d'exposition vivant où artisans, centres de formation, entreprises vertes et jeunes innovateurs présentent leurs technologies : séchoirs solaires, biodigesteurs, outils de transformation agricole. Chaque stand propose des démonstrations dynamiques en continu. Des services techniques à coût réduit, notamment le scannage et le diagnostic automobile, sont offerts au grand public pour montrer l'utilité directe des métiers techniques.",
            ],
            [
                'title' => 'Ateliers pratiques d’apprentissage (« Learning by Doing »)',
                'icon' => 'bi-tools',
                'summary' => '50 jeunes sélectionnés fabriquent concrètement des solutions lors de sessions de formation courte de 2 heures.',
                'description' => "Des sessions intensives de formation courte animées par des experts du CFL, du projet FoRCE et des professionnels du secteur. D'une durée de 2 heures, ces ateliers permettent à 50 jeunes sélectionnés de fabriquer ou monter concrètement des solutions : montage de systèmes solaires photovoltaïques, fabrication d'engrais organiques à compostage rapide et confection de dispositifs de cuisson écologique.",
            ],
            [
                'title' => 'Panels de discussion & espace d’orientation des familles',
                'icon' => 'bi-people',
                'summary' => 'Débats stratégiques avec experts et décideurs, et point d’information permanent dédié aux parents d’élèves.',
                'description' => "Des débats stratégiques réunissent experts, décideurs publics (DDESTFP, ANPE), partenaires (Coopération Suisse/FoRCE, ProFOP, Azôli) et acteurs économiques autour de l'insertion, de la transition écologique et de l'avenir des métiers. Un point d'information permanent conseille les parents sur les filières porteuses et les opportunités de financement d'études ou d'apprentissage pour leurs enfants.",
            ],
            [
                'title' => 'Rencontres B2B & synergie territoriale',
                'icon' => 'bi-briefcase',
                'summary' => 'Des échanges professionnels structurés pour négocier contrats de fourniture, conventions de stage et apprentissages.',
                'description' => "Un cadre d'échanges professionnels permettant aux jeunes créateurs de rencontrer acheteurs, ONG, mairies et entreprises pour négocier des contrats de fourniture d'équipements ou des conventions de stage et d'apprentissage. L'événement se clôture par l'évaluation et la remise de prix à trois innovations technologiques locales prometteuses pour accélérer leur mise sur le marché.",
            ],
            [
                'title' => 'Grand Prix de l’innovation & concours de pitch « Solutions Atacora Durable »',
                'icon' => 'bi-trophy',
                'summary' => '5 groupes de jeunes créateurs défendent en 5 minutes une innovation face à un jury d’experts et au public.',
                'description' => "Cinq groupes de jeunes créateurs, lycéens ou élèves présélectionnés disposent de cinq minutes de pitch ou de démonstration face à un jury composé d'experts (CFL, Coopération Suisse/FoRCE, ANPE, chefs d'entreprises) et du public. Objectif : défendre une innovation technique, agricole ou artisanale concrète répondant aux défis climatiques et économiques de l'Atacora. Les trois meilleures prestations reçoivent des prix d'encouragement : outillages, kits techniques ou accompagnement à l'incubation.",
            ],
        ];

        foreach ($components as $i => $c) {
            ProgramComponent::updateOrCreate(
                ['title' => $c['title']],
                array_merge($c, ['sort_order' => $i + 1, 'is_visible' => true])
            );
        }

        // ------------------------------------------------------------------
        // Agenda détaillé des 3 jours
        // ------------------------------------------------------------------
        $d1 = Carbon::parse('2026-11-19');
        $d2 = Carbon::parse('2026-11-20');
        $d3 = Carbon::parse('2026-11-21');

        $schedule = [
            [$d1, '08:00', '09:30', 'Cérémonie d’ouverture & lancement officiel', 'Mots de bienvenue, présentation du salon et du thème 2026.', 'Espace conférence'],
            [$d1, '09:30', '10:30', 'Parcours d’orientation — arrivée des navettes Minibus Écoles', 'Accueil des premiers groupes d’élèves par les guides-animateurs.', 'Accueil du site'],
            [$d1, '10:30', '12:30', 'Foire d’exposition : démonstrations pratiques en continu', 'Première session de démonstrations sur les stands des exposants.', 'Hall d’exposition'],
            [$d1, '13:00', '15:00', 'Atelier pratique n°1 : montage de systèmes solaires photovoltaïques', 'Session « learning by doing » pour les jeunes sélectionnés.', 'Salle atelier'],
            [$d1, '15:30', '17:00', 'Panel : insertion professionnelle et avenir des métiers techniques', 'Échanges avec la DDESTFP, l’ANPE et les partenaires du secteur.', 'Espace conférence'],

            [$d2, '08:30', '10:00', 'Atelier pratique n°2 : engrais organiques à compostage rapide', 'Fabrication concrète d’engrais organiques avec les experts du CFL.', 'Salle atelier'],
            [$d2, '10:00', '12:30', 'Foire & services techniques subventionnés', 'Démonstrations, scannage et diagnostic automobile à coût réduit.', 'Hall d’exposition'],
            [$d2, '13:00', '14:30', 'Espace d’orientation des familles', 'Conseil aux parents sur les filières porteuses et les financements.', 'Stand information'],
            [$d2, '14:30', '16:30', 'Atelier pratique n°3 : dispositifs de cuisson écologique', 'Confection de foyers améliorés et solutions de cuisson propre.', 'Salle atelier'],
            [$d2, '16:30', '18:00', 'Rencontres B2B & synergie territoriale', 'Mise en relation jeunes créateurs, entreprises, ONG et collectivités.', 'Espace B2B'],

            [$d3, '09:00', '11:00', 'Rencontres B2B (suite) & conventions de stage', 'Négociation des contrats de fourniture et conventions d’apprentissage.', 'Espace B2B'],
            [$d3, '11:00', '12:30', 'Concours de pitch « Solutions Atacora Durable »', '5 groupes, 5 minutes de pitch chacun devant le jury et le public.', 'Espace conférence'],
            [$d3, '13:00', '14:30', 'Délibérations du jury & évaluation à chaud', 'Évaluation des innovations et mesure de satisfaction des participants.', 'Salle jury'],
            [$d3, '15:00', '16:30', 'Remise des prix aux 3 innovations locales primées', 'Dotation en outillages, kits techniques et accompagnement à l’incubation.', 'Espace conférence'],
            [$d3, '16:30', '17:30', 'Cérémonie de clôture', 'Bilan du salon, annonces de partenariats et perspectives 2027.', 'Espace conférence'],
        ];

        foreach ($schedule as $i => [$date, $start, $end, $title, $desc, $location]) {
            $day = Carbon::parse($date);
            ScheduleItem::updateOrCreate(
                ['title' => $title, 'day_date' => $day->toDateString()],
                [
                    'day_label' => 'Jour '.($day->isSameDay($d1) ? '1' : ($day->isSameDay($d2) ? '2' : '3'))
                        .' — '.$day->isoFormat('dddd D MMMM YYYY'),
                    'start_time' => $start,
                    'end_time' => $end,
                    'description' => $desc,
                    'location' => $location,
                    'sort_order' => $i + 1,
                    'is_visible' => true,
                ]
            );
        }

        // ------------------------------------------------------------------
        // Partenaires (écosystème en cours de mobilisation selon le document)
        // ------------------------------------------------------------------
        $partners = [
            ['REJEVE Bénin', 'Organisateur', 'Réseau des Jeunes pour l’Économie Verte, organisateur du SaLMeTE.'],
            ['Actforcommunity', 'ONGs nationales & internationales', ''],
            ['Eco-Bénin', 'ONGs nationales & internationales', ''],
            ['UCOOPIA', 'ONGs nationales & internationales', ''],
            ['GERES', 'ONGs nationales & internationales', ''],
            ['Îles de Paix', 'ONGs nationales & internationales', ''],
            ['SNV', 'ONGs nationales & internationales', ''],
            ['VSF', 'ONGs nationales & internationales', ''],
            ['Helvetas', 'ONGs nationales & internationales', ''],
            ['Technoserve / BENIBIZ', 'ONGs nationales & internationales', ''],
            ['APEFE', 'ONGs nationales & internationales', ''],
            ['AISER', 'ONGs nationales & internationales', ''],
            ['Eclosio', 'ONGs nationales & internationales', ''],
            ['Inti — Énergies Solidaires', 'ONGs nationales & internationales', ''],
            ['PNUD', 'Agences UN & bailleurs', 'Programme des Nations Unies pour le développement.'],
            ['Coopération Suisse / FoRCE', 'Agences UN & bailleurs', 'Formation Professionnelle pour l’Emploi.'],
            ['GIZ / ProFOP', 'Agences UN & bailleurs', 'Programme de formation professionnelle en alternance.'],
            ['UNFPA', 'Agences UN & bailleurs', 'Fonds des Nations Unies pour la population.'],
            ['CMA', 'Institutions & chambres consulaires', 'Chambre des Métiers de l’Artisanat.'],
            ['Maison des Artisans', 'Institutions & chambres consulaires', ''],
            ['Mairies de l’Atacora', 'Institutions & chambres consulaires', ''],
            ['ANPE', 'Institutions & chambres consulaires', 'Agence Nationale pour l’Emploi.'],
            ['DDESTFP', 'Institutions & chambres consulaires', 'Direction Départementale de l’Enseignement Secondaire Technique et de la Formation Professionnelle.'],
            ['CFL — Centre de Formation Liweitari', 'Centres de formation & réseaux', ''],
            ['Lycées Techniques Agricoles', 'Centres de formation & réseaux', 'Réseau des LTA du Nord-Bénin.'],
            ['Start-ups vertes du Nord-Bénin', 'Centres de formation & réseaux', 'Jeunes pousses de l’agrobusiness vert et des énergies renouvelables.'],
        ];

        foreach ($partners as $i => [$name, $category, $description]) {
            Partner::updateOrCreate(
                ['name' => $name],
                [
                    'category' => $category,
                    'description' => $description,
                    'sort_order' => $i + 1,
                    'is_visible' => true,
                ]
            );
        }

        // ------------------------------------------------------------------
        // Formules de sponsoring & mécénat
        // ------------------------------------------------------------------
        $offers = [
            ['Stand — Institutions internationales', 'Institutions internationales', 0, 'Tarif à définir', 'Prise en charge d’un stand d’exposition', "Stand aménagé sur les 3 jours\nVisibilité sur les kakemonos institutionnels\nPrésentation de l'organisation dans le programme officiel\nAccès aux rencontres B2B", 'Formule institutionnelle'],
            ['Stand — ONGs nationales', 'ONGs nationales', 0, 'Tarif à définir', 'Prise en charge d’un stand d’exposition', "Stand sur les 3 jours\nVisibilité logo sur les supports du salon\nAccès aux rencontres B2B", null],
            ['Stand — Centres de formation & écoles', 'Centres de formation & écoles', 0, 'Tarif à définir', 'Prise en charge d’un stand d’exposition', "Stand dédié à l'offre de formation\nEspace de démonstration pédagogique\nMise en relation avec les jeunes en orientation", null],
            ['Stand — Jeunes entrepreneurs & artisans', 'Jeunes entrepreneurs & artisans', 0, 'Tarif à définir', 'Tarif solidaire pour les créateurs locaux', "Stand à coût réduit\nDémonstrations dynamiques autorisées\nMise en relation directe avec acheteurs et coopératives", 'Tarif solidaire'],
            ['Parrainage de participants / Bourses jeunes', 'Bourse jeune', 30000, '/ jeune', 'Couvre la formule complète d’un jeune pendant 3 jours', "Formation pratique sur les 3 jours\nT-shirt du participant\nAttestation de participation\nHébergement et collation", null],
            ['Sponsoring d’activités & Prix d’innovation', 'Activités & prix', 0, 'Sur devis', 'Financement d’un atelier technique ou du Grand Prix de l’innovation', "Dotation en outillage et kits solaires\nAmorçage financier de l'innovation primée\nVisibilité renforcée lors de la remise des prix", null],
            ['Appui technique, logistique & média', 'Appui en nature', 0, 'Sur devis', 'Soutien en matériel, couverture média ou communication', "Matériel de démonstration\nCouverture vidéo/photo\nDiffusion sur les radios locales et les réseaux sociaux", null],
        ];

        foreach ($offers as $i => [$name, $audience, $price, $note, $description, $features, $badge]) {
            SponsorOffer::updateOrCreate(
                ['name' => $name],
                [
                    'audience' => $audience,
                    'price' => $price,
                    'price_note' => $note,
                    'description' => $description,
                    'features' => $features,
                    'badge' => $badge,
                    'sort_order' => $i + 1,
                    'is_visible' => true,
                ]
            );
        }

        $this->call(GallerySeeder::class);

        // ------------------------------------------------------------------
        // Données de démonstration (supprimables depuis l'administration),
        // jamais créées en production
        // ------------------------------------------------------------------
        if (app()->isProduction()) {
            return;
        }

        Registration::updateOrCreate(
            ['email' => 'demo.exposant@salmete.bj'],
            [
                'type' => 'exposant',
                'full_name' => 'Démonstration — Exposant',
                'organization' => 'Coopérative verte de Natitingou',
                'phone' => '+229 01 00 00 00 01',
                'profile' => 'Jeune entrepreneur',
                'message' => 'Souhaite réserver un stand pour présenter des séchoirs solaires.',
                'status' => 'nouveau',
            ]
        );

        Registration::updateOrCreate(
            ['email' => 'demo.participant@salmete.bj'],
            [
                'type' => 'participant',
                'full_name' => 'Démonstration — Participant',
                'organization' => 'Lycée technique de Natitingou',
                'phone' => '+229 01 00 00 00 02',
                'profile' => 'Élève / étudiant',
                'message' => 'Candidate aux ateliers pratiques de montage de kits solaires.',
                'status' => 'en_cours',
            ]
        );

        ContactMessage::updateOrCreate(
            ['email' => 'demo.partenaire@salmete.bj'],
            [
                'name' => 'Démonstration — Partenaire',
                'phone' => '+229 01 00 00 00 03',
                'subject' => 'Demande de partenariat',
                'message' => 'Bonjour, notre organisation souhaite étudier une formule de sponsoring pour l’édition 2026.',
                'is_read' => false,
            ]
        );
    }

    /**
     * Create the administrator account without ever overwriting an existing password.
     */
    private function seedAdministrator(): void
    {
        $email = config('app.admin.email');

        if (User::where('email', $email)->exists()) {
            return;
        }

        $password = config('app.admin.password') ?: Str::password(16);

        User::create([
            'name' => 'Administration SaLMeTE',
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        if (! config('app.admin.password')) {
            $this->command?->warn("Compte admin créé : {$email} / {$password} (à changer dès la première connexion)");
        }
    }
}
