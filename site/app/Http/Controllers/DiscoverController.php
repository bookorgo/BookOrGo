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
        $catalogue = $this->samples->browse([]);
        $featured = [
            $this->samples->detail('activities', 'dubai', 'sample-desert-morning'),
            $this->samples->detail('activities', 'abu-dhabi', 'sample-city-view'),
            $this->samples->detail('cruises', 'dubai', 'sample-creek-cruise'),
            $this->samples->detail('yachts', 'dubai-marina', 'sample-marina-yacht'),
        ];

        return view('home', [
            'categories' => $this->directory->all(),
            'destinations' => [
                ['name' => 'Dubai', 'motif' => 'arch'],
                ['name' => 'Dubai Marina', 'motif' => 'sail'],
                ['name' => 'Abu Dhabi', 'motif' => 'ship'],
                ['name' => 'Ras Al Khaimah', 'motif' => 'spark'],
                ['name' => 'Fujairah', 'motif' => 'sun'],
                ['name' => 'Sharjah', 'motif' => 'passport'],
            ],
            'featured' => $featured,
            'durations' => $catalogue['durations'],
            'articles' => $this->articles->all(),
        ]);
    }

    public function information(string $page): View
    {
        $pages = [
            'about' => ['title' => 'About BookOrGo', 'heading' => 'A new way to explore the UAE', 'body' => 'BookOrGo is being built as a Dubai-first UAE travel discovery and editorial website. The current public preview contains fictional catalogue records and draft guide templates, not live travel offers.'],
            'contact' => ['title' => 'Contact', 'heading' => 'Contact details are being prepared', 'body' => 'A verified public support address has not been published in this preview. No contact form is active and no booking support service is offered here.'],
            'disclosure' => ['title' => 'Affiliate disclosure', 'heading' => 'Know where a booking will happen', 'body' => 'No affiliate link or advertisement is active in this preview. Before any referral is enabled, the relevant partner, disclosure and permitted link must be verified. Future partner checkout will be external; BookOrGo does not currently take payments or issue confirmations.'],
            'privacy' => ['title' => 'Privacy policy draft', 'heading' => 'Privacy notice — draft', 'body' => 'This is a placeholder for the reviewed privacy notice, not a finalized legal policy. Account, newsletter, contact-form, advertising and analytics collection are not enabled in this application. Server operations may generate request logs; hosting retention and complete processing details still require review. Do not submit personal or payment information.'],
            'terms' => ['title' => 'Terms draft', 'heading' => 'Terms of use — draft', 'body' => 'Final terms require owner and legal review. This preview is for examining page layouts; fictional records are not offers, advice, prices, availability, visa approvals or recommendations. No booking, payment or fulfilment service is available here.'],
        ];
        abort_unless(isset($pages[$page]), 404);

        return view('information', ['categories' => $this->directory->all(), 'page' => $pages[$page]]);
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
