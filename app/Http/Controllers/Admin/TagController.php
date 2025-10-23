<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('query'));

        $tags = Tag::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('news.tags.index', [
            'tags' => $tags,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('news.tags.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();

        if (!empty($input['slug'])) {
            $input['slug'] = Str::slug($input['slug']);
        }

        $validated = validator($input, [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('tags', 'slug')],
            'is_active' => ['nullable', 'boolean'],
        ])->validate();

        $validated['is_active'] = array_key_exists('is_active', $validated)
            ? (bool) $validated['is_active']
            : true;

        Tag::create($validated);

        return redirect()
            ->route('news.tags.index')
            ->with('status', 'Tag berhasil dibuat.');
    }

    public function edit(Tag $tag): View
    {
        return view('news.tags.edit', [
            'tag' => $tag,
        ]);
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $input = $request->all();

        if (!empty($input['slug'])) {
            $input['slug'] = Str::slug($input['slug']);
        }

        $validated = validator($input, [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('tags', 'slug')->ignore($tag->getKey())],
            'is_active' => ['nullable', 'boolean'],
        ])->validate();

        if (!array_key_exists('slug', $validated)) {
            $validated['slug'] = $tag->slug;
        }

        $validated['is_active'] = array_key_exists('is_active', $validated)
            ? (bool) $validated['is_active']
            : $tag->is_active;

        $tag->update($validated);

        return redirect()
            ->route('news.tags.index')
            ->with('status', 'Tag berhasil diperbarui.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()
            ->route('news.tags.index')
            ->with('status', 'Tag berhasil dihapus.');
    }

    public function toggle(Request $request, Tag $tag): RedirectResponse
    {
        $tag->update([
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('news.tags.index')
            ->with('status', 'Status tag diperbarui.');
    }
}
