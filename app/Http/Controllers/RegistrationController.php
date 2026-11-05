<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('public.registrations.create', [
            'types' => Registration::TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:participant,exposant',
            'full_name' => 'required|string|max:255',
            'organization' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:40',
            'profile' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:2000',
            'rgpd' => 'accepted',
            'website' => 'prohibited',
        ], [
            'rgpd.accepted' => 'Vous devez accepter d’être recontacté par l’organisation du salon.',
        ]);

        Registration::create($validated);

        return back()
            ->with('success', 'Votre inscription a bien été enregistrée. L’organisation du SaLMeTE vous recontactera très prochainement.');
    }
}
