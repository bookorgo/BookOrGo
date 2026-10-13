<?php

namespace App\Domain\Content;

/**
 * Original, factual-claim-free draft records used to exercise the P1 article UI.
 * These are not published travel advice and intentionally have no author/date/source claims.
 */
final class SampleArticleDirectory
{
    public function all(): array
    {
        return [
            $this->article(
                'sample-first-visit-planning',
                'Planning a first Dubai visit: a decision framework',
                'A draft layout showing how a future guide can organise verified choices without pretending that research is complete.',
                'First-visit planning',
                'compass',
                [
                    ['id' => 'start-with-purpose', 'title' => 'Start with the purpose of the trip', 'body' => 'A useful plan begins with the traveller’s priorities. A future reviewed guide can separate family time, culture, outdoor activities and slower days before suggesting any place or schedule.'],
                    ['id' => 'group-nearby-ideas', 'title' => 'Group nearby ideas', 'body' => 'The final article should group verified places by area and travel time using current sources. This preview reserves that structure without making a transport or duration claim.'],
                    ['id' => 'verify-before-booking', 'title' => 'Verify before choosing', 'body' => 'Opening times, access rules, age limits, prices and availability can change. They must be checked against approved current sources before the guide is reviewed for publication.'],
                ],
                ['activities/dubai/sample-desert-morning', 'events/dubai/sample-family-event'],
            ),
            $this->article(
                'sample-family-day-planning',
                'Building a family day plan: a guide template',
                'A draft structure for balancing interests, rest and verified access information.',
                'Family planning',
                'spark',
                [
                    ['id' => 'define-needs', 'title' => 'Define the group’s needs', 'body' => 'A reviewed guide should state who each suggestion may suit only when age, accessibility and entry information has a named current source.'],
                    ['id' => 'leave-room', 'title' => 'Leave room in the plan', 'body' => 'The template keeps recommendations short and scannable so an editor can add verified practical detail without creating an overloaded itinerary.'],
                    ['id' => 'source-the-details', 'title' => 'Source every changing detail', 'body' => 'Dates, operating times, restrictions and availability remain outside this preview. Publication requires evidence and editorial approval.'],
                ],
                ['activities/abu-dhabi/sample-city-view', 'events/dubai/sample-family-event'],
            ),
            $this->article(
                'sample-uae-weekend-planning',
                'Shaping a UAE weekend: an editorial outline',
                'A draft article pattern for connecting destination ideas with verified category pages.',
                'UAE trip planning',
                'route',
                [
                    ['id' => 'choose-a-base', 'title' => 'Choose a practical base', 'body' => 'A future article can compare areas only after transport context and suitable sources are recorded. This outline does not recommend a hotel or claim a journey time.'],
                    ['id' => 'balance-the-days', 'title' => 'Balance the days', 'body' => 'Editors can use this section to mix different kinds of verified experiences while keeping enough space for practical notes and accessibility information.'],
                    ['id' => 'review-current-info', 'title' => 'Review current information', 'body' => 'Every volatile statement must carry source evidence and a review date before the draft becomes eligible for publication.'],
                ],
                ['holidays/dubai/sample-city-break', 'activities/ras-al-khaimah/sample-mountain-day'],
            ),
        ];
    }

    public function find(string $slug): ?array
    {
        foreach ($this->all() as $article) {
            if ($article['slug'] === $slug) {
                return $article;
            }
        }

        return null;
    }

    private function article(string $slug, string $title, string $summary, string $topic, string $motif, array $sections, array $related): array
    {
        return [
            'slug' => $slug,
            'title' => $title,
            'summary' => $summary,
            'topic' => $topic,
            'motif' => $motif,
            'author' => null,
            'reviewer' => null,
            'published_at' => null,
            'updated_at' => null,
            'sections' => $sections,
            'related' => $related,
            'references' => [],
            'status' => 'Draft template preview',
        ];
    }
}
