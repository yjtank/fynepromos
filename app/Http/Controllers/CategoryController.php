<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('categories.index', [
            'categories' => Category::withCount('offers')->orderBy('name')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        Category::create($data);

        return to_route('categories.index')->with('status', 'Categoria criada com sucesso.');
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $category->name === $data['name'] ? $category->slug : $this->uniqueSlug($data['name'], $category->id);
        $category->update($data);

        return to_route('categories.index')->with('status', 'Categoria atualizada com sucesso.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->offers()->exists()) {
            return to_route('categories.index')->with('error', 'Não é possível excluir uma categoria que possui promoções. Desative-a ou mova as promoções antes.');
        }

        $category->delete();

        return to_route('categories.index')->with('status', 'Categoria excluída com sucesso.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'active' => ['boolean'],
        ]) + ['active' => $request->boolean('active')];
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'categoria';
        $slug = $base;
        $counter = 2;

        while (Category::where('slug', $slug)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
