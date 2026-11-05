<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        return view('admin.galleries.index', [
            'galleries' => Gallery::orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.galleries.form', ['gallery' => new Gallery()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['image'] = $request->file('image')->store('gallery', 'public');

        Gallery::create($data);

        return redirect()->route('admin.galerie.index')
            ->with('success', 'Photo ajoutée à la galerie.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.form', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $this->validateData($request, $gallery->exists);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image);
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.galerie.index')
            ->with('success', 'Photo mise à jour.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return redirect()->route('admin.galerie.index')
            ->with('success', 'Photo supprimée.');
    }

    private function validateData(Request $request, bool $existing = false): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'image' => ($existing ? 'nullable' : 'required') . '|image|max:5120',
            'category' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
        ]);

        unset($data['image']);
        $data['is_visible'] = $request->boolean('is_visible');
        $data['sort_order'] = $request->input('sort_order', 0);

        return $data;
    }
}
