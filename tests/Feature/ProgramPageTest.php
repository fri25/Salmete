<?php

namespace Tests\Feature;

use App\Models\ScheduleItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_program_page_shows_day_tabs_and_countdown_to_first_session(): void
    {
        ScheduleItem::create([
            'day_label' => 'Jour 1 — jeudi 19 novembre 2026',
            'day_date' => '2026-11-19',
            'start_time' => '08:00',
            'end_time' => '09:30',
            'title' => 'Cérémonie d’ouverture',
            'location' => 'Espace conférence',
            'is_visible' => true,
        ]);
        ScheduleItem::create([
            'day_label' => 'Jour 2 — vendredi 20 novembre 2026',
            'day_date' => '2026-11-20',
            'start_time' => '08:30',
            'title' => 'Atelier compostage',
            'is_visible' => true,
        ]);
        ScheduleItem::create([
            'day_label' => 'Jour 2 — vendredi 20 novembre 2026',
            'day_date' => '2026-11-20',
            'start_time' => '10:00',
            'title' => 'Session masquée',
            'is_visible' => false,
        ]);

        $response = $this->get(route('program'));

        $response->assertOk()
            ->assertSee('data-countdown="2026-11-19T08:00:00', false)
            ->assertSeeInOrder(['Jour 1', 'Jeudi 19 novembre 2026', 'Jour 2', 'Vendredi 20 novembre 2026'])
            ->assertSee('Cérémonie d’ouverture')
            ->assertSee('08h00 – 09h30')
            ->assertDontSee('Session masquée')
            ->assertSee(route('registrations.store'), false);
    }

    public function test_program_page_renders_without_schedule(): void
    {
        $this->get(route('program'))
            ->assertOk()
            ->assertSee("L'agenda sera publié prochainement.", false)
            ->assertSee('Le programme du SaLMeTE 2026')
            ->assertDontSee('data-countdown=', false);
    }

    public function test_registration_from_program_page_redirects_back_with_success(): void
    {
        $response = $this->from(route('program'))->post(route('registrations.store'), [
            'type' => 'participant',
            'full_name' => 'Awa Sabi',
            'email' => 'awa@example.com',
            'phone' => '+229 01 00 00 00',
            'rgpd' => '1',
        ]);

        $response->assertRedirect(route('program'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('registrations', [
            'email' => 'awa@example.com',
            'type' => 'participant',
        ]);
    }
}
