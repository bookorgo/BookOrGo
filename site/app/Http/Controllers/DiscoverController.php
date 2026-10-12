<?php

namespace App\Http\Controllers;

use App\Domain\Catalog\CategoryDirectory;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class DiscoverController extends Controller
{
    public function __construct(private CategoryDirectory $directory) {}

    public function home(): View
    {
        return view('home', ['categories' => $this->directory->all()]);
    }

    public function category(string $category): View
    {
        $categories = $this->directory->all();
        abort_unless(isset($categories[$category]), 404);

        return view('category', ['categories' => $categories, 'category' => $categories[$category], 'slug' => $category]);
    }

    public function search(Request $request): View
    {
        $query = $request->query('q', '');
        abort_unless(is_string($query) && mb_strlen($query) <= 120, 422, 'Enter a search of up to 120 characters.');
        $query = trim($query);

        return view('search', ['categories' => $this->directory->all(), 'results' => $this->directory->search($query), 'query' => $query]);
    }

    public function journal(): View
    {
        return view('journal', ['categories' => $this->directory->all()]);
    }
}
