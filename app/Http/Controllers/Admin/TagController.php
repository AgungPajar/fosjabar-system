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
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');
        $perPage = (int) $request->query('per_page', 10);

        $allowedSorts = ['name', 'slug', 'is_active', 'created_at'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        $direction = $direction === 'asc' ? 'asc' : 'desc';
        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 10;
        }

        $tags = Tag::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();

        return view('news.tags.index', [
            'tags' => $tags,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
            'perPage' => $perPage,
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

        return $this->redirectWithStatus($request, 'Tag berhasil dibuat.');
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

        return $this->redirectWithStatus($request, 'Tag berhasil diperbarui.');
    }

    public function destroy(Request $request, Tag $tag): RedirectResponse
    {
        $tag->delete();

        return $this->redirectWithStatus($request, 'Tag berhasil dihapus.');
    }

    public function toggle(Request $request, Tag $tag): RedirectResponse
    {
        $tag->update([
            'is_active' => $request->boolean('is_active'),
        ]);

        return $this->redirectWithStatus($request, 'Status tag diperbarui.');
    }

    protected function redirectWithStatus(Request $request, string $message): RedirectResponse
    {
        $target = $request->input('redirect');

        if ($target && filter_var($target, FILTER_VALIDATE_URL)) {
            return redirect()->to($target)->with('status', $message);
        }

        if ($target && str_starts_with($target, '/')) {
            return redirect($target)->with('status', $message);
        }

        return redirect()->route('news.tags.index')->with('status', $message);
    }
}
