<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    private array $fields = [
        'site_name', 'site_tagline', 'site_edition', 'hero_theme',
        'event_dates', 'event_location', 'home_intro',
        'about_context', 'about_goal_general', 'about_goal_specific',
        'about_results', 'about_followup',
        'stat_participants', 'stat_participants_label',
        'stat_exposants', 'stat_exposants_label',
        'stat_partnerships', 'stat_partnerships_label',
        'stat_youth', 'stat_youth_label',
        'stat_awards', 'stat_awards_label',
        'contact_org', 'contact_email', 'contact_phone', 'contact_address',
        'social_facebook', 'social_youtube', 'social_whatsapp', 'footer_about',
    ];

    public function edit()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            ...array_fill_keys($this->fields, 'nullable|string|max:5000'),
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:40',
            'social_facebook' => 'nullable|url:http,https|max:255',
            'social_youtube' => 'nullable|url:http,https|max:255',
            'social_whatsapp' => 'nullable|string|max:40',
            'site_logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('site_logo')) {
            $oldLogo = Setting::get('site_logo');
            $logoPath = $request->file('site_logo')->store('brand', 'public');

            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            Setting::put('site_logo', $logoPath);
        }

        foreach ($this->fields as $field) {
            if ($request->has($field)) {
                Setting::put($field, $request->input($field));
            }
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Paramètres du site enregistrés.');
    }
}
