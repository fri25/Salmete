<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramComponent;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function index()
    {
        return view('admin.components.index', [
            'components' => ProgramComponent::orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.components.form', ['component' => new ProgramComponent()]);
    }

    public function store(Request $request)
    {
        ProgramComponent::create($this->validateData($request));

        return redirect()->route('admin.composantes.index')
            ->with('success', 'Composante ajoutée avec succès.');
    }

    public function edit(ProgramComponent $component)
    {
        return view('admin.components.form', compact('component'));
    }

    public function update(Request $request, ProgramComponent $component)
    {
        $component->update($this->validateData($request));

        return redirect()->route('admin.composantes.index')
            ->with('success', 'Composante mise à jour avec succès.');
    }

    public function destroy(ProgramComponent $component)
    {
        $component->delete();

        return redirect()->route('admin.composantes.index')
            ->with('success', 'Composante supprimée.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:80',
            'summary' => 'required|string|max:500',
            'description' => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
        ]) + ['is_visible' => $request->boolean('is_visible'), 'sort_order' => $request->input('sort_order', 0)];
    }
}
