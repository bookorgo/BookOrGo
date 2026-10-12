<?php

namespace Tests\Feature;

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
            $response->assertSee('href="http://localhost/'.$slug.'"', false);
        }
    }

    public function test_each_category_has_honest_empty_state_and_unknown_category_is_missing(): void
    {
        foreach (['activities', 'holidays', 'visas', 'cruises', 'yachts', 'events'] as $slug) {
            $this->get('/'.$slug)->assertOk()->assertSee('This collection is taking shape')
                ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        }
        $this->get('/visas')->assertSee('No application or approval service is currently offered.');
        $this->get('/unknown')->assertNotFound();
        $this->get('/activities/nonexistent-offer')->assertNotFound();
    }

    public function test_search_finds_taxonomy_and_handles_empty_and_unknown_queries(): void
    {
        $this->get('/search?q=boat')->assertOk()->assertSee('Cruises')->assertSee('Yachts')
            ->assertSee('card-ship', false)->assertSee('card-sail', false)->assertDontSee('card-passport', false);
        $this->get('/search?q=ACTIVITIES')->assertOk()->assertSee('card-sun', false);
        $this->get('/search')->assertOk()->assertSee('All categories');
        $this->get('/search?q=nothingmatches')->assertOk()->assertSee('No matching categories yet');
    }

    public function test_search_rejects_non_scalar_and_overlong_input_and_escapes_html(): void
    {
        $this->get('/search?q[]=boat')->assertStatus(422);
        $this->get('/search?q='.str_repeat('a', 121))->assertStatus(422);
        $query = '<script>alert(1)</script>';
        $this->get('/search?q='.rawurlencode($query))->assertOk()->assertSee($query)
            ->assertDontSee($query, false);
    }

    public function test_canonical_uses_configured_origin_and_excludes_search_parameters(): void
    {
        config(['app.url' => 'https://bookorgo.com']);
        $this->get('/search?q=boat')->assertOk()
            ->assertSee('<link rel="canonical" href="https://bookorgo.com/search">', false);
        $this->get('/')->assertSee('<link rel="canonical" href="https://bookorgo.com/">', false);
        $this->get('/blog')->assertOk()->assertSee('No articles have been published yet.');
    }
}
