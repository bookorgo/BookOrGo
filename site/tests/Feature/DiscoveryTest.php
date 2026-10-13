<?php

namespace Tests\Feature;

use App\Domain\Catalog\SampleExperienceDirectory;
use Tests\TestCase;

final class DiscoveryTest extends TestCase
{
    public function test_home_is_server_rendered_without_database_or_live_offers(): void
    {
        config(['database.default' => 'mysql', 'database.connections.mysql.host' => 'unreachable.invalid']);
        $response = $this->get('/');
        $response->assertOk()->assertSee('Your next UAE', false)->assertSee('Development preview')
            ->assertSee('No live offers or bookings yet.')->assertSee('noindex, nofollow');
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
        }
    }

    public function test_canonical_uses_configured_origin_excludes_filters_and_stays_noindex(): void
    {
        config(['app.url' => 'https://bookorgo.com']);
        $this->get('/search?q=boat&sort=title-asc')->assertOk()
            ->assertSee('<link rel="canonical" href="https://bookorgo.com/search">', false)
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false);
        $this->get('/')->assertSee('<link rel="canonical" href="https://bookorgo.com/">', false);
        $this->get('/blog')->assertOk()->assertSee('No articles have been published yet.');
    }
}
