<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScheduleItem;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('admin.schedule.index', [
            'items' => ScheduleItem::orderBy('day_date')->orderBy('start_time')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.schedule.form', ['item' => new ScheduleItem()]);
    }

    public function store(Request $request)
    {
        ScheduleItem::create($this->validateData($request));

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Créneau ajouté à l’agenda.');
    }

    public function edit(ScheduleItem $schedule)
    {
        return view('admin.schedule.form', ['item' => $schedule]);
    }

    public function update(Request $request, ScheduleItem $schedule)
    {
        $schedule->update($this->validateData($request));

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Créneau mis à jour.');
    }

    public function destroy(ScheduleItem $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Créneau supprimé.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'day_label' => 'required|string|max:255',
            'day_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
        ]);

        $data['is_visible'] = $request->boolean('is_visible');
        $data['sort_order'] = $request->input('sort_order', 0);

        return $data;
    }
}
