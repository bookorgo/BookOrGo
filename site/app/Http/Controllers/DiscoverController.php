<?php

namespace App\Http\Controllers;

use App\Domain\Catalog\CategoryDirectory;
use App\Domain\Catalog\SampleExperienceDirectory;
use App\Domain\Content\SampleArticleDirectory;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

final class DiscoverController extends Controller
{
    public function __construct(
        private CategoryDirectory $directory,
        private SampleExperienceDirectory $samples,
        private SampleArticleDirectory $articles,
    ) {}

    public function home(): View
    {
        return view('home', ['categories' => $this->directory->all()]);
    }

    public function category(Request $request, string $category): View|Response
    {
        $categories = $this->directory->all();
        abort_unless(isset($categories[$category]), 404);

        return $this->listing($request, $category, $categories[$category]);
    }

    public function search(Request $request): View|Response
    {
        return $this->listing($request);
    }

    public function journal(): View
    {
        return view('journal', [
            'categories' => $this->directory->all(),
            'articles' => $this->articles->all(),
        ]);
    }

    public function article(string $article): View
    {
        $record = $this->articles->find($article);
        abort_if($record === null, 404);

        $related = [];
        foreach ($record['related'] as $path) {
            [$category, $location, $experience] = explode('/', $path);
            $item = $this->samples->detail($category, $location, $experience);
            if ($item !== null) {
                $related[] = $item;
            }
        }

        return view('article', [
            'categories' => $this->directory->all(),
            'article' => $record,
            'related' => $related,
        ]);
    }

    public function detail(string $category, string $location, string $experience): View
    {
        $categories = $this->directory->all();
        abort_unless(isset($categories[$category]), 404);

        $item = $this->samples->detail($category, $location, $experience);
        abort_if($item === null, 404);

        return view('detail', [
            'categories' => $categories,
            'category' => $categories[$category],
            'item' => $item,
            'related' => $this->samples->related($category, $experience),
        ]);
    }

    private function listing(Request $request, ?string $fixedCategory = null, ?array $category = null): View|Response
    {
        $categories = $this->directory->all();

        try {
            $listing = $this->samples->browse($request->query(), $fixedCategory);
        } catch (InvalidArgumentException $exception) {
            return response()->view('listing-error', [
                'categories' => $categories,
                'message' => $exception->getMessage(),
                'resetUrl' => $fixedCategory === null ? route('search') : route('category', $fixedCategory),
            ], 422);
        }

        $listing['categories'] = $categories;
        $listing['fixedCategory'] = $fixedCategory;
        $listing['category'] = $category;
        $listing['action'] = $fixedCategory === null ? route('search') : route('category', $fixedCategory);

        return view('listing', $listing);
    }
}
