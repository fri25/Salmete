<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        return view('admin.partners.index', [
            'partners' => Partner::orderBy('category')->orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.partners.form', ['partner' => new Partner()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['logo'] = $this->storeLogo($request);

        Partner::create($data);

        return redirect()->route('admin.partenaires.index')
            ->with('success', 'Partenaire ajouté avec succès.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.form', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $this->validateData($request);

        if ($path = $this->storeLogo($request)) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $path;
        }

        $partner->update($data);

        return redirect()->route('admin.partenaires.index')
            ->with('success', 'Partenaire mis à jour.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }
        $partner->delete();

        return redirect()->route('admin.partenaires.index')
            ->with('success', 'Partenaire supprimé.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|max:3072',
            'url' => 'nullable|url:http,https|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
        ]);

        $data['is_visible'] = $request->boolean('is_visible');
        $data['sort_order'] = $request->input('sort_order', 0);
        unset($data['logo']);

        return $data;
    }

    private function storeLogo(Request $request): ?string
    {
        if (! $request->hasFile('logo')) {
            return null;
        }

        return $request->file('logo')->store('partners', 'public');
    }
}
