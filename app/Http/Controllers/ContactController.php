<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:40',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:3000',
            'website' => 'prohibited',
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact')
            ->with('success', 'Votre message a bien été envoyé. Merci de nous avoir contactés !');
    }
}
