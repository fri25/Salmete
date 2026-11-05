<?php

namespace Tests\Feature;

use App\Models\Registration;
use App\Models\ScheduleItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_dashboard_shows_indicators_and_days_left_before_opening(): void
    {
        Carbon::setTestNow('2026-11-02 10:00:00');

        $admin = User::factory()->create(['name' => 'Awa Sabi', 'is_admin' => true]);

        ScheduleItem::create([
            'day_label' => 'Jour 1 — jeudi 19 novembre 2026',
            'day_date' => '2026-11-19',
            'start_time' => '08:00',
            'title' => 'Ouverture',
            'is_visible' => true,
        ]);
        Registration::create(['type' => 'participant', 'full_name' => 'Kossi Participant', 'email' => 'p@example.com', 'phone' => '01', 'status' => 'nouveau']);
        Registration::create(['type' => 'exposant', 'full_name' => 'Coop Exposant', 'email' => 'e@example.com', 'phone' => '02', 'status' => 'accepte']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('J-17')
            ->assertSee('1 participant · 1 exposant')
            ->assertSee('Nouvelles demandes en attente')
            ->assertSee('Kossi Participant')
            ->assertSee('AS');
    }

    public function test_dashboard_requires_an_administrator(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_login_page_renders_for_guests(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Connexion')
            ->assertSee('name="password"', false);
    }
}
