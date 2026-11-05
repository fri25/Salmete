<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\SponsorOffer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnersPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_partners_page_lists_partners_and_sponsoring_offers(): void
    {
        Partner::create(['name' => 'Helvetas', 'category' => 'Partenaires techniques', 'is_visible' => true]);
        Partner::create(['name' => 'Partenaire masqué', 'category' => 'Partenaires techniques', 'is_visible' => false]);
        SponsorOffer::create(['name' => 'Stand — ONGs nationales', 'audience' => 'ONGs nationales', 'price' => 100000, 'is_visible' => true]);
        SponsorOffer::create(['name' => 'Offre masquée', 'audience' => 'ONGs nationales', 'price' => 5000, 'is_visible' => false]);

        $this->get(route('partners'))
            ->assertOk()
            ->assertSeeInOrder(['id="partenaires"', 'Helvetas', 'id="sponsoring"', 'Stand — ONGs nationales', '100 000 FCFA'], false)
            ->assertDontSee('Partenaire masqué')
            ->assertDontSee('Offre masquée');
    }

    public function test_sponsoring_url_redirects_permanently_to_the_sponsoring_section(): void
    {
        $this->get('/sponsoring')
            ->assertStatus(301)
            ->assertRedirect('/partenaires#sponsoring');
    }
}
