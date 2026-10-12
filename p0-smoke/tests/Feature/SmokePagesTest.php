<?php

namespace Tests\Feature;

use Tests\TestCase;

class SmokePagesTest extends TestCase
{
    public function test_homepage_is_server_rendered_and_noindex(): void
    {
        $this->get(route('p0.home'))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex,nofollow">', false)
            ->assertSee('<link rel="canonical" href="'.route('p0.home').'">', false)
            ->assertSee('Plan what to explore, then book with an approved partner')
            ->assertSeeInOrder(['Activities', 'Holidays', 'Visas', 'Cruises', 'Yachts', 'Events']);
    }

    public function test_detail_is_truthful_and_has_no_live_offer(): void
    {
        $this->get(route('p0.detail'))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex,nofollow">', false)
            ->assertSee('<link rel="canonical" href="'.route('p0.detail').'">', false)
            ->assertSee('Sample Dubai activity detail')
            ->assertSee('No live offer')
            ->assertSee('Partner link unavailable in sample')
            ->assertDontSee('Book now');
    }

    public function test_article_is_server_rendered_and_release_gated(): void
    {
        $this->get(route('p0.article'))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex,nofollow">', false)
            ->assertSee('<link rel="canonical" href="'.route('p0.article').'">', false)
            ->assertSee('How a future Dubai guide will help visitors decide')
            ->assertSee('Publication remains blocked');
    }
}
