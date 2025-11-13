<?php

namespace Tests\Unit;

use App\Helpers\SportConfig;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SportConfigTest extends TestCase
{
    #[Test]
    public function it_returns_all_available_sports()
    {
        $sports = SportConfig::getSports();

        $this->assertIsArray($sports);
        $this->assertArrayHasKey('football', $sports);
        $this->assertArrayHasKey('basketball', $sports);
        $this->assertArrayHasKey('baseball', $sports);
        $this->assertArrayHasKey('track', $sports);
        $this->assertArrayHasKey('soccer', $sports);
    }

    #[Test]
    public function it_returns_positions_for_football()
    {
        $positions = SportConfig::getPositions('football');

        $this->assertIsArray($positions);
        $this->assertArrayHasKey('QB', $positions);
        $this->assertArrayHasKey('WR', $positions);
        $this->assertArrayHasKey('RB', $positions);
        $this->assertEquals('Quarterback', $positions['QB']);
    }

    #[Test]
    public function it_returns_positions_for_basketball()
    {
        $positions = SportConfig::getPositions('basketball');

        $this->assertIsArray($positions);
        $this->assertArrayHasKey('PG', $positions);
        $this->assertArrayHasKey('SG', $positions);
        $this->assertEquals('Point Guard', $positions['PG']);
    }

    #[Test]
    public function it_returns_positions_for_baseball()
    {
        $positions = SportConfig::getPositions('baseball');

        $this->assertIsArray($positions);
        $this->assertArrayHasKey('P', $positions);
        $this->assertArrayHasKey('C', $positions);
        $this->assertEquals('Pitcher', $positions['P']);
    }

    #[Test]
    public function it_returns_positions_for_track()
    {
        $positions = SportConfig::getPositions('track');

        $this->assertIsArray($positions);
        $this->assertArrayHasKey('Sprints', $positions);
        $this->assertArrayHasKey('Distance', $positions);
    }

    #[Test]
    public function it_returns_positions_for_soccer()
    {
        $positions = SportConfig::getPositions('soccer');

        $this->assertIsArray($positions);
        $this->assertArrayHasKey('GK', $positions);
        $this->assertArrayHasKey('DEF', $positions);
        $this->assertEquals('Goalkeeper', $positions['GK']);
    }

    #[Test]
    public function it_returns_empty_array_for_unknown_sport()
    {
        $positions = SportConfig::getPositions('unknown');

        $this->assertIsArray($positions);
        $this->assertEmpty($positions);
    }

    #[Test]
    public function it_returns_stat_fields_for_football()
    {
        $fields = SportConfig::getStatFields('football');

        $this->assertIsArray($fields);
        $this->assertArrayHasKey('games_played', $fields);
        $this->assertArrayHasKey('receptions', $fields);
        $this->assertArrayHasKey('receiving_yards', $fields);
        $this->assertArrayHasKey('touchdowns', $fields);
    }

    #[Test]
    public function it_returns_stat_fields_for_basketball()
    {
        $fields = SportConfig::getStatFields('basketball');

        $this->assertIsArray($fields);
        $this->assertArrayHasKey('points_per_game', $fields);
        $this->assertArrayHasKey('rebounds_per_game', $fields);
        $this->assertArrayHasKey('assists_per_game', $fields);
    }

    #[Test]
    public function it_returns_stat_fields_for_baseball()
    {
        $fields = SportConfig::getStatFields('baseball');

        $this->assertIsArray($fields);
        $this->assertArrayHasKey('batting_avg', $fields);
        $this->assertArrayHasKey('home_runs', $fields);
        $this->assertArrayHasKey('rbis', $fields);
    }

    #[Test]
    public function it_returns_stat_fields_for_track()
    {
        $fields = SportConfig::getStatFields('track');

        $this->assertIsArray($fields);
        $this->assertArrayHasKey('events_competed', $fields);
        $this->assertArrayHasKey('best_time_100m', $fields);
    }

    #[Test]
    public function it_returns_stat_fields_for_soccer()
    {
        $fields = SportConfig::getStatFields('soccer');

        $this->assertIsArray($fields);
        $this->assertArrayHasKey('goals', $fields);
        $this->assertArrayHasKey('assists', $fields);
        $this->assertArrayHasKey('saves', $fields);
    }

    #[Test]
    public function stat_fields_include_field_configurations()
    {
        $fields = SportConfig::getStatFields('football');

        $this->assertArrayHasKey('label', $fields['games_played']);
        $this->assertArrayHasKey('type', $fields['games_played']);
        $this->assertEquals('Games Played', $fields['games_played']['label']);
        $this->assertEquals('number', $fields['games_played']['type']);
    }

    #[Test]
    public function it_returns_skills_for_football()
    {
        $skills = SportConfig::getSkills('football');

        $this->assertIsArray($skills);
        $this->assertArrayHasKey('Speed & Agility', $skills);
        $this->assertArrayHasKey('Route Running', $skills);
        $this->assertArrayHasKey('Leadership', $skills);
    }

    #[Test]
    public function it_returns_skills_for_basketball()
    {
        $skills = SportConfig::getSkills('basketball');

        $this->assertIsArray($skills);
        $this->assertArrayHasKey('Ball Handling', $skills);
        $this->assertArrayHasKey('Shooting', $skills);
    }

    #[Test]
    public function it_returns_skills_for_baseball()
    {
        $skills = SportConfig::getSkills('baseball');

        $this->assertIsArray($skills);
        $this->assertArrayHasKey('Hitting', $skills);
        $this->assertArrayHasKey('Fielding', $skills);
    }

    #[Test]
    public function it_returns_skills_for_track()
    {
        $skills = SportConfig::getSkills('track');

        $this->assertIsArray($skills);
        $this->assertArrayHasKey('Speed', $skills);
        $this->assertArrayHasKey('Endurance', $skills);
    }

    #[Test]
    public function it_returns_skills_for_soccer()
    {
        $skills = SportConfig::getSkills('soccer');

        $this->assertIsArray($skills);
        $this->assertArrayHasKey('Ball Control', $skills);
        $this->assertArrayHasKey('Passing', $skills);
    }

    #[Test]
    public function skills_have_default_values()
    {
        $skills = SportConfig::getSkills('football');

        foreach ($skills as $skill => $value) {
            $this->assertIsInt($value);
            $this->assertGreaterThanOrEqual(0, $value);
            $this->assertLessThanOrEqual(100, $value);
        }
    }
}
