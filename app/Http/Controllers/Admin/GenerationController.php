<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Generation;
use App\Models\Participant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GenerationController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = (int) $request->query('per_page', 10);

        $generations = Generation::query()
            ->withCount('participants')
            ->orderByDesc('created_at')
            ->paginate(in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 10)
            ->withQueryString();

        $leaders = Participant::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.generations.index', [
            'generations' => $generations,
            'leaders' => $leaders,
        ]);
    }

    public function create(): View
    {
        return view('admin.generations.create', [
            'participants' => Participant::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'singkatan' => ['required', 'string', 'max:50'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['required', 'date', 'after_or_equal:started_at'],
            'is_active' => ['sometimes', 'boolean'],
            'participants_id' => ['nullable', 'uuid', Rule::exists('participants', 'id')],
        ]);

        $validated['is_active'] = array_key_exists('is_active', $validated)
            ? (bool) $validated['is_active']
            : true;

        Generation::create($validated);

        return redirect()->route('admin.generations.index')
            ->with('status', 'Generasi berhasil dibuat.');
    }

    public function edit(Generation $generation): View
    {
        return view('admin.generations.edit', [
            'generation' => $generation->load('leader'),
            'participants' => Participant::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Generation $generation): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'singkatan' => ['required', 'string', 'max:50'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['required', 'date', 'after_or_equal:started_at'],
            'is_active' => ['sometimes', 'boolean'],
            'participants_id' => ['nullable', 'uuid', Rule::exists('participants', 'id')],
        ]);

        if (!array_key_exists('is_active', $validated)) {
            $validated['is_active'] = $generation->is_active;
        }

        $generation->update($validated);

        return redirect()->route('admin.generations.index')
            ->with('status', 'Generasi berhasil diperbarui.');
    }

    public function destroy(Generation $generation): RedirectResponse
    {
        $generation->delete();

        return redirect()->route('admin.generations.index')
            ->with('status', 'Generasi berhasil dihapus.');
    }
}
