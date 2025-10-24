<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Generation;
use App\Models\Participant;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ParticipantController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('query'));
        $perPage = (int) $request->query('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 10;

        $participants = Participant::query()
            ->with(['generation', 'positions'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('participants.index', [
            'participants' => $participants,
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }

    public function create(): View
    {
        return view('participants.create', [
            'generations' => Generation::orderBy('name')->get(['id', 'name']),
            'positions' => Position::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('participants', 'username')],
            'email' => ['required', 'email', 'max:255', Rule::unique('participants', 'email')],
            'no_hp' => ['required', 'string', 'max:30'],
            'birthday' => ['nullable', 'date'],
            'from_school' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'generations_id' => ['nullable', 'uuid', Rule::exists('generations', 'id')],
            'positions' => ['nullable', 'array'],
            'positions.*' => ['uuid', Rule::exists('positions', 'id')],
        ]);

        $positions = $validated['positions'] ?? [];
        unset($validated['positions']);

        $validated['password'] = Hash::make($validated['password']);

        $participant = Participant::create($validated);
        $participant->positions()->sync($positions);

        return redirect()->route('participants.index')
            ->with('status', 'Peserta berhasil dibuat.');
    }

    public function edit(Participant $participant): View
    {
        $participant->load('positions', 'generation');

        return view('participants.edit', [
            'participant' => $participant,
            'generations' => Generation::orderBy('name')->get(['id', 'name']),
            'positions' => Position::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Participant $participant): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('participants', 'username')->ignore($participant->getKey())],
            'email' => ['required', 'email', 'max:255', Rule::unique('participants', 'email')->ignore($participant->getKey())],
            'no_hp' => ['required', 'string', 'max:30'],
            'birthday' => ['nullable', 'date'],
            'from_school' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'generations_id' => ['nullable', 'uuid', Rule::exists('generations', 'id')],
            'positions' => ['nullable', 'array'],
            'positions.*' => ['uuid', Rule::exists('positions', 'id')],
        ]);

        $positions = $validated['positions'] ?? null;
        unset($validated['positions']);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $participant->update($validated);

        if (is_array($positions)) {
            $participant->positions()->sync($positions);
        }

        return redirect()->route('participants.index')
            ->with('status', 'Peserta berhasil diperbarui.');
    }

    public function destroy(Participant $participant): RedirectResponse
    {
        $participant->delete();

        return redirect()->route('participants.index')
            ->with('status', 'Peserta berhasil dihapus.');
    }
}
