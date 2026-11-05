<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $registrations = Registration::query()
            ->when($request->type, fn ($q, $type) => $q->where('type', $type))
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.registrations.index', [
            'registrations' => $registrations,
            'types' => Registration::TYPES,
            'statuses' => Registration::STATUS,
        ]);
    }

    public function show(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }

    public function updateStatus(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:nouveau,en_cours,accepte,refuse',
            'admin_note' => 'nullable|string|max:2000',
        ]);

        $registration->update($validated);

        return back()->with('success', 'Statut de l’inscription mis à jour.');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        return redirect()->route('admin.inscriptions.index')
            ->with('success', 'Inscription supprimée.');
    }

    public function export(): StreamedResponse
    {
        $filename = 'inscriptions-salmete-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, [
                'ID', 'Type', 'Nom complet', 'Organisation', 'E-mail',
                'Téléphone', 'Profil', 'Message', 'Statut', 'Note admin', 'Date',
            ], ';');

            Registration::orderBy('created_at')->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $r) {
                    fputcsv($out, array_map($this->escapeCsvFormula(...), [
                        $r->id,
                        Registration::TYPES[$r->type] ?? $r->type,
                        $r->full_name,
                        $r->organization,
                        $r->email,
                        $r->phone,
                        $r->profile,
                        $r->message,
                        Registration::STATUS[$r->status] ?? $r->status,
                        $r->admin_note,
                        $r->created_at->format('d/m/Y H:i'),
                    ]), ';');
                }
            });

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Neutralise values that a spreadsheet would interpret as a formula (CSV injection).
     */
    private function escapeCsvFormula(mixed $value): mixed
    {
        if (is_string($value) && preg_match('/^[=+\-@\t\r]/', $value)) {
            return "'" . $value;
        }

        return $value;
    }
}
