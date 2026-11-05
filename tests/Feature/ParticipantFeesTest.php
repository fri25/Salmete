<?php

namespace Tests\Feature;

use App\Models\SponsorOffer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipantFeesTest extends TestCase
{
    use RefreshDatabase;

    public function test_program_page_lists_participant_fees_and_free_visit(): void
    {
        $this->get(route('program'))
            ->assertOk()
            ->assertSeeInOrder(['2 000 FCFA', '5 000 FCFA', '15 000 FCFA', '30 000 FCFA'])
            ->assertSee('libre et gratuite', false);
    }

    public function test_registration_page_lists_participant_fees(): void
    {
        $this->get(route('registrations.create'))
            ->assertOk()
            ->assertSee('id="participantFees"', false)
            ->assertSeeInOrder(['2 000 FCFA', '30 000 FCFA']);
    }

    public function test_exhibitors_page_shows_undefined_stand_fee_and_free_visit(): void
    {
        SponsorOffer::create([
            'name' => 'Stand — ONGs nationales',
            'audience' => 'ONGs nationales',
            'price' => 0,
            'price_note' => 'Tarif à définir',
            'is_visible' => true,
        ]);

        $this->get(route('exhibitors'))
            ->assertOk()
            ->assertSee('Tarif à définir')
            ->assertDontSee('0 FCFA')
            ->assertSee('libre et gratuite', false);
    }
}
