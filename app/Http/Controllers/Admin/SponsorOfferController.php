<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SponsorOffer;
use Illuminate\Http\Request;

class SponsorOfferController extends Controller
{
    public function index()
    {
        return view('admin.offers.index', [
            'offers' => SponsorOffer::orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.offers.form', ['offer' => new SponsorOffer()]);
    }

    public function store(Request $request)
    {
        SponsorOffer::create($this->validateData($request));

        return redirect()->route('admin.sponsoring.index')
            ->with('success', 'Formule de sponsoring ajoutée.');
    }

    public function edit(SponsorOffer $offer)
    {
        return view('admin.offers.form', compact('offer'));
    }

    public function update(Request $request, SponsorOffer $offer)
    {
        $offer->update($this->validateData($request));

        return redirect()->route('admin.sponsoring.index')
            ->with('success', 'Formule mise à jour.');
    }

    public function destroy(SponsorOffer $offer)
    {
        $offer->delete();

        return redirect()->route('admin.sponsoring.index')
            ->with('success', 'Formule supprimée.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'audience' => 'nullable|string|max:255',
            'price' => 'nullable|integer|min:0',
            'price_note' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'features' => 'nullable|string',
            'badge' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
        ]);

        $data['price'] = $request->input('price', 0) ?? 0;
        $data['is_visible'] = $request->boolean('is_visible');
        $data['sort_order'] = $request->input('sort_order', 0);

        return $data;
    }
}
