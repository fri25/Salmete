<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $captions = [
            ['Présentation de kits solaires et d’outils électriques', 'Expositions'],
            ['Échange autour d’un équipement présenté sur un stand', 'Échanges & rencontres'],
            ['Foyers améliorés et équipements de cuisson exposés', 'Expositions'],
            ['Intervention d’une participante devant le public', 'Participants'],
            ['Présentation d’une solution aux visiteurs', 'Démonstrations'],
            ['Rencontre entre un exposant et un participant', 'Échanges & rencontres'],
            ['Présentation collective de créations artisanales', 'Artisanat & produits locaux'],
            ['Un exposant présente un produit et l’affiche du salon', 'Expositions'],
            ['Présentation de vêtements et de créations textiles', 'Artisanat & produits locaux'],
            ['Présentation de créations textiles aux visiteurs', 'Artisanat & produits locaux'],
            ['Échange autour de créations textiles', 'Artisanat & produits locaux'],
            ['Les visiteurs assistent aux activités du salon', 'Participants'],
            ['Discussion autour d’une activité du salon', 'Échanges & rencontres'],
            ['Groupe de visiteurs devant un stand d’exposition', 'Participants'],
            ['Démonstration d’un équipement de cuisson', 'Démonstrations'],
            ['Groupe d’exposants devant leur espace', 'Participants'],
            ['Photo de groupe des participants', 'Participants'],
            ['Portrait d’une participante devant l’affiche du salon', 'Participants'],
            ['Présentation d’articles artisanaux sur un stand', 'Artisanat & produits locaux'],
            ['Portrait d’un exposant devant le stand', 'Participants'],
            ['Échange entre visiteurs et exposants', 'Échanges & rencontres'],
            ['Discussion entre visiteurs autour d’un stand', 'Échanges & rencontres'],
            ['Présentation d’un équipement aux visiteurs', 'Démonstrations'],
            ['Démonstration technique d’un appareil', 'Démonstrations'],
            ['Les participants suivent une présentation', 'Participants'],
            ['Équipements artisanaux exposés en plein air', 'Expositions'],
            ['Plans et illustrations d’équipements présentés au salon', 'Expositions'],
            ['Appareil de mesure présenté sur un stand', 'Démonstrations'],
            ['Produits et panneau solaire exposés sur un stand', 'Expositions'],
            ['Produits transformés exposés au salon', 'Artisanat & produits locaux'],
            ['Démonstration d’un équipement de cuisson', 'Démonstrations'],
            ['Sacs de riz local exposés au salon', 'Artisanat & produits locaux'],
        ];

        foreach ($captions as $index => [$title, $category]) {
            $sortOrder = $index + 1;
            $image = 'gallery/gal-'.str_pad((string) $sortOrder, 3, '0', STR_PAD_LEFT).'.jpg';

            if (! Storage::disk('public')->exists($image)) {
                continue;
            }

            Gallery::updateOrCreate(
                ['image' => $image],
                [
                    'title' => $title,
                    'category' => $category,
                    'sort_order' => $sortOrder,
                    'is_visible' => true,
                ]
            );
        }
    }
}
