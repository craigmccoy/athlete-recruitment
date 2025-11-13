<?php

namespace Tests\Feature;

use App\Models\AthleteProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function homepage_includes_meta_title()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'graduation_year' => 2026,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<title>', false);
        $response->assertSee('John Smith', false);
        $response->assertSee($profile->footballProfile->position, false);
    }

    #[Test]
    public function homepage_includes_meta_description()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'school_name' => 'Test High School',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<meta name="description"', false);
        $response->assertSee('John Smith', false);
        $response->assertSee($profile->footballProfile->position, false);
        $response->assertSee('Test High School', false);
    }

    #[Test]
    public function homepage_includes_open_graph_tags()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('og:title', false);
        $response->assertSee('og:description', false);
        $response->assertSee('og:type', false);
        $response->assertSee('og:url', false);
    }

    #[Test]
    public function homepage_includes_twitter_card_tags()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('twitter:card', false);
        $response->assertSee('twitter:title', false);
        $response->assertSee('twitter:description', false);
    }

    #[Test]
    public function homepage_includes_structured_data()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'school_name' => 'Test High School',
            'email' => 'athlete@example.com',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('application/ld+json', false);
        $response->assertSee('schema.org', false);
        $response->assertSee('"@type": "Person"', false);
    }

    #[Test]
    public function structured_data_includes_athlete_information()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'school_name' => 'Test High School',
            'email' => 'athlete@example.com',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $content = $response->content();
        
        // Check for JSON-LD structure
        $this->assertStringContainsString('John Smith', $content);
        $this->assertStringContainsString($profile->footballProfile->position, $content);
        $this->assertStringContainsString('"@type":"Person"', str_replace(' ', '', $content));
    }

    #[Test]
    public function sitemap_is_accessible()
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
    }

    #[Test]
    public function sitemap_includes_homepage()
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertSee('<url>', false);
        $response->assertSee('<loc>', false);
        $response->assertSee(url('/'), false);
    }

    #[Test]
    public function sitemap_is_valid_xml()
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false);
        $response->assertSee('xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', false);
    }

    #[Test]
    public function robots_txt_is_accessible()
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
    }

    #[Test]
    public function robots_txt_includes_sitemap()
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertSee('Sitemap:');
        $response->assertSee('sitemap.xml');
    }

    #[Test]
    public function robots_txt_allows_crawlers()
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertSee('User-agent: *');
        $response->assertSee('Allow: /');
    }

    #[Test]
    public function meta_tags_include_sport_when_not_football()
    {
        $profile = AthleteProfile::factory()->basketball()->create([
            'name' => 'Jane Doe',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Basketball', false);
        $response->assertSee($profile->basketballProfile->position, false);
    }

    #[Test]
    public function meta_tags_exclude_sport_label_for_football()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'sport' => 'football',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        // Should not say "football" explicitly since it's default
        $content = $response->content();
        $titleContent = $this->extractMetaContent($content, 'title');
        
        // Title should not contain "(football)"
        $this->assertStringNotContainsString('(football)', $titleContent);
    }

    #[Test]
    public function homepage_includes_canonical_url()
    {
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<link rel="canonical"', false);
    }

    protected function extractMetaContent($html, $name)
    {
        preg_match('/<title>(.*?)<\/title>/s', $html, $matches);
        return $matches[1] ?? '';
    }
}
