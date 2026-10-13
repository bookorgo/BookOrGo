<?php

namespace Tests\Feature;

use App\Domain\Catalog\SampleExperienceDirectory;
use Tests\TestCase;

final class DiscoveryTest extends TestCase
{
    public function test_reference_homepage_modules_are_original_uae_only_and_non_commercial(): void
    {
        $response = $this->get('/');
        $response->assertOk()->assertSee('Where do you want to go?')->assertSee('Ideas worth exploring')
            ->assertSee('Newsletter preview only.')->assertSee('Subscriptions are not open.')
            ->assertDontSee('London')->assertDontSee('Register')->assertDontSee('Sign in');
        $this->assertSame(6, substr_count($response->getContent(), 'class="destination-card"'));
        $this->assertSame(4, substr_count($response->getContent(), 'class="featured-card"'));
        $this->assertSame(3, substr_count($response->getContent(), 'class="home-guide"'));
        $response->assertSee('area=Dubai', false)->assertSee('Original illustration');
    }

    public function test_gallery_location_faq_and_referral_disclosure_do_not_fabricate_facts(): void
    {
        $response = $this->get('/activities/dubai/sample-desert-morning');
        $response->assertOk()->assertSee('not venue photographs')->assertSee('No venue photos supplied')
            ->assertSee('No verified address')->assertSee('Frequently asked questions')
            ->assertSee('No affiliate link is active here.')->assertDontSee('maps.googleapis.com', false)
            ->assertDontSee('application/ld+json', false);
        $this->assertSame(6, substr_count($response->getContent(), 'class="gallery-tile"'));
        $this->assertSame(6, substr_count($response->getContent(), 'Not supplied in this preview'));
    }

    public function test_footer_information_routes_are_honest_noindex_drafts(): void
    {
        foreach (['about', 'contact', 'disclosure', 'privacy', 'terms'] as $page) {
            $response = $this->get('/'.$page);
            $response->assertOk()->assertSee('Draft information.')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
            $this->assertSame(1, substr_count($response->getContent(), '<h1'));
        }
        $this->get('/contact')->assertSee('No contact form is active');
        $this->get('/privacy')->assertSee('not a finalized legal policy');
    }

    public function test_listing_top_search_and_external_sort_form_preserve_supported_filters(): void
    {
        $response = $this->get('/search?q=boat&sort=title-desc');
        $response->assertOk()->assertSee('class="listing-search"', false)
            ->assertSee('form="catalogue-filter-form"', false)->assertSee('Apply sort')
            ->assertSee('value="boat"', false)->assertDontSee('Lowest price');
    }
    public function test_home_is_server_rendered_without_database_or_live_offers(): void
    {
        config(['database.default' => 'mysql', 'database.connections.mysql.host' => 'unreachable.invalid']);
        $response = $this->get('/');
        $response->assertOk()->assertSee('Your next great', false)->assertSee('Development preview')
            ->assertSee('No live offers or bookings.')->assertSee('noindex, nofollow');
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $this->assertSame(1, substr_count($response->getContent(), '<h1'));
        foreach (['activities', 'holidays', 'visas', 'cruises', 'yachts', 'events'] as $slug) {
            $response->assertSee('href="'.rtrim(config('app.url'), '/').'/'.$slug.'"', false);
        }
    }

    public function test_each_category_has_three_clearly_labelled_fictional_cards(): void
    {
        foreach (['activities', 'holidays', 'visas', 'cruises', 'yachts', 'events'] as $slug) {
            $response = $this->get('/'.$slug);
            $response->assertOk()->assertSee('sample catalogue')->assertSee('Demonstration data only.')
                ->assertSee('No live offer or price')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
            $this->assertSame(3, substr_count($response->getContent(), 'class="experience-card"'));
        }
        $this->get('/visas')->assertSee('no eligibility or approval claim');
        $this->get('/unknown')->assertNotFound();
        $this->get('/activities/nonexistent-offer')->assertNotFound();
    }

    public function test_each_category_has_a_category_aware_detail_variant(): void
    {
        $cases = [
            '/activities/dubai/sample-desert-morning' => ['Activity detail template', 'Ticket variant', 'Accessibility'],
            '/holidays/dubai/sample-city-break' => ['Holiday detail template', 'Number of nights', 'Guest limits'],
            '/visas/uae-wide/sample-tourist-visa-guide' => ['Visa information template', 'Applicant eligibility', 'Last verified date'],
            '/cruises/dubai/sample-creek-cruise' => ['Cruise detail template', 'Boarding point', 'Dining options'],
            '/yachts/dubai-marina/sample-marina-yacht' => ['Yacht detail template', 'Capacity', 'Package constraints'],
            '/events/dubai/sample-family-event' => ['Event detail template', 'Event date', 'Access policy'],
        ];

        foreach ($cases as $path => $expected) {
            $response = $this->get($path);
            $response->assertOk()->assertSee($expected)->assertSee('Fictional sample')
                ->assertSee('Not supplied in this preview')->assertSee('No live option yet')
                ->assertSee('disabled aria-disabled="true"', false)
                ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
            $this->assertSame(1, substr_count($response->getContent(), '<h1'));
        }

        $this->get('/visas/uae-wide/sample-tourist-visa-guide')
            ->assertSee('not immigration advice')->assertSee('current official sources');
    }

    public function test_all_sample_cards_link_to_unique_stable_detail_urls(): void
    {
        $directory = app(SampleExperienceDirectory::class);
        $items = [];
        foreach ([1, 2, 3] as $page) {
            $items = [...$items, ...$directory->browse(['page' => (string) $page])['items']];
        }

        $urls = [];
        foreach ($items as $item) {
            $path = sprintf('/%s/%s/%s', $item['category'], $item['location_slug'], $item['id']);
            $urls[] = $path;
            $this->get($path)->assertOk()->assertSee($item['title'])
                ->assertSee('href="'.rtrim(config('app.url'), '/').$path.'"', false);
        }

        $this->assertCount(18, array_unique($urls));
    }

    public function test_detail_routes_reject_mismatched_or_unknown_records(): void
    {
        $this->get('/activities/abu-dhabi/sample-desert-morning')->assertNotFound();
        $this->get('/events/dubai/sample-desert-morning')->assertNotFound();
        $this->get('/activities/dubai/sample-unknown')->assertNotFound();
        $this->get('/activities/dubai/not-a-sample')->assertNotFound();
    }

    public function test_search_matches_cards_and_has_an_honest_empty_state(): void
    {
        $boat = $this->get('/search?q=boat');
        $boat->assertOk()->assertSee('6 fictional cards')->assertSee('Cruises')->assertSee('Yachts')
            ->assertDontSee('card-passport', false);
        $this->assertSame(6, substr_count($boat->getContent(), 'class="experience-card"'));

        $all = $this->get('/search');
        $all->assertOk()->assertSee('18 fictional cards')->assertSee('Page 1 of 3');
        $this->assertSame(6, substr_count($all->getContent(), 'class="experience-card"'));

        $this->get('/search?q=ACTIVITIES')->assertOk()->assertSee('3 fictional cards');
        $this->get('/search?q=nothingmatches')->assertOk()->assertSee('No sample cards match')
            ->assertSee('No product will be invented');
    }

    public function test_filters_and_truthful_title_sort_are_deterministic(): void
    {
        $filtered = $this->get('/search?category=yachts&area=Dubai%20Marina&duration=under-2-hours&family=yes');
        $filtered->assertOk()->assertSee('1 fictional card')->assertSee('Marina yacht layout concept')
            ->assertDontSee('Sunset yacht layout concept');

        $this->get('/search?category=yachts&sort=title-desc')->assertOk()->assertSeeInOrder([
            'Sunset yacht layout concept',
            'Marina yacht layout concept',
            'Island yacht layout concept',
        ]);
    }

    public function test_pagination_is_stable_and_preserves_filters(): void
    {
        $response = $this->get('/search?q=sample&page=2');
        $response->assertOk()->assertSee('18 fictional cards')->assertSee('Page 2 of 3')
            ->assertSee('q=sample&amp;sort=recommended&amp;page=3', false);
        $this->assertSame(6, substr_count($response->getContent(), 'class="experience-card"'));
    }

    public function test_invalid_filters_pages_and_non_scalar_input_return_safe_error(): void
    {
        $this->get('/search?q[]=boat')->assertStatus(422)->assertSee('couldn’t apply those filters');
        $this->get('/search?q='.str_repeat('a', 121))->assertStatus(422);
        $this->get('/search?category=hotels')->assertStatus(422);
        $this->get('/search?sort=price-lowest')->assertStatus(422);
        $this->get('/search?page=4')->assertStatus(422)->assertSee('results page is not available');

        $query = '<script>alert(1)</script>';
        $this->get('/search?q='.rawurlencode($query))->assertOk()->assertSee($query)
            ->assertDontSee($query, false);
    }

    public function test_sample_records_have_unique_ids_and_no_commercial_fields(): void
    {
        $directory = app(SampleExperienceDirectory::class);
        $items = [];
        foreach ([1, 2, 3] as $page) {
            $items = [...$items, ...$directory->browse(['page' => (string) $page])['items']];
        }

        $this->assertCount(18, $items);
        $this->assertCount(18, array_unique(array_column($items, 'id')));
        foreach ($items as $item) {
            $this->assertArrayNotHasKey('price', $item);
            $this->assertArrayNotHasKey('availability', $item);
            $this->assertArrayNotHasKey('rating', $item);
            $this->assertMatchesRegularExpression('/^[a-z0-9-]+$/', $item['location_slug']);
        }
    }

    public function test_canonical_uses_configured_origin_excludes_filters_and_stays_noindex(): void
    {
        config(['app.url' => 'https://bookorgo.com']);
        $this->get('/search?q=boat&sort=title-asc')->assertOk()
            ->assertSee('<link rel="canonical" href="https://bookorgo.com/search">', false)
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false);
        $this->get('/')->assertSee('<link rel="canonical" href="https://bookorgo.com/">', false);
        $this->get('/blog')->assertOk()->assertSee('3 draft guide templates')
            ->assertSee('Authors, dates, factual sources, imagery and publication approval are intentionally withheld');
    }

    public function test_journal_hub_has_three_labelled_draft_article_cards(): void
    {
        $response = $this->get('/blog');
        $response->assertOk()->assertSee('Drafts only.')->assertSee('No live ads or affiliate links')
            ->assertSee('Not assigned')->assertSee('Not published')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->assertSame(3, substr_count($response->getContent(), 'class="article-card"'));
        $this->assertSame(1, substr_count($response->getContent(), '<h1'));
    }

    public function test_article_template_exposes_editorial_gates_without_false_publication_claims(): void
    {
        $response = $this->get('/blog/sample-first-visit-planning');
        $response->assertOk()->assertSee('Draft template preview')->assertSee('On this page')
            ->assertSee('At a glance')->assertSee('Not assigned in this preview')
            ->assertSee('Not published')->assertSee('No factual sources attached')
            ->assertSee('Inactive preview — no ad loaded')
            ->assertSee('No advertisement or affiliate link is active')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $response->assertDontSee('<script type="application/ld+json">', false);
        $this->assertSame(1, substr_count($response->getContent(), '<h1'));
        $this->assertSame(3, substr_count($response->getContent(), 'class="article-section"'));
        $this->assertSame(2, substr_count($response->getContent(), '<article>'));
    }

    public function test_all_draft_article_urls_are_stable_and_unknown_articles_are_404(): void
    {
        foreach (['sample-first-visit-planning', 'sample-family-day-planning', 'sample-uae-weekend-planning'] as $slug) {
            $this->get('/blog/'.$slug)->assertOk()
                ->assertSee('href="'.rtrim(config('app.url'), '/').'/blog/'.$slug.'"', false);
        }

        $this->get('/blog/sample-unknown-guide')->assertNotFound();
        $this->get('/blog/not-a-sample')->assertNotFound();
    }
}
