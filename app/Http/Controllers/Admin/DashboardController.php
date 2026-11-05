<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\ProgramComponent;
use App\Models\Registration;
use App\Models\ScheduleItem;
use App\Models\SponsorOffer;

class DashboardController extends Controller
{
    public function index()
    {
        $firstSession = ScheduleItem::where('is_visible', true)
            ->orderBy('day_date')->orderBy('start_time')->first();

        return view('admin.dashboard', [
            'eventStartsAt' => $firstSession?->day_date->copy()->setTimeFromTimeString($firstSession->start_time ?: '08:00'),
            'registrationsByType' => Registration::selectRaw('type, count(*) as total')->groupBy('type')->pluck('total', 'type'),
            'registrationsByStatus' => Registration::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'counts' => [
                'registrations' => Registration::count(),
                'newRegistrations' => Registration::where('status', 'nouveau')->count(),
                'messages' => ContactMessage::count(),
                'unreadMessages' => ContactMessage::where('is_read', false)->count(),
                'partners' => Partner::count(),
                'galleries' => Gallery::count(),
                'components' => ProgramComponent::count(),
                'schedule' => ScheduleItem::count(),
                'offers' => SponsorOffer::count(),
            ],
            'latestRegistrations' => Registration::latest()->limit(6)->get(),
            'latestMessages' => ContactMessage::latest()->limit(5)->get(),
        ]);
    }
}
