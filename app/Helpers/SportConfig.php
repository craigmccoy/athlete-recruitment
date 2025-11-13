<?php

namespace App\Helpers;

class SportConfig
{
    /**
     * Get all available sports
     */
    public static function getSports(): array
    {
        return [
            'football' => 'Football',
            'basketball' => 'Basketball',
            'baseball' => 'Baseball',
            'track' => 'Track & Field',
            'soccer' => 'Soccer',
        ];
    }

    /**
     * Get positions for a specific sport
     */
    public static function getPositions(string $sport): array
    {
        return match($sport) {
            'football' => [
                'QB' => 'Quarterback',
                'RB' => 'Running Back',
                'WR' => 'Wide Receiver',
                'TE' => 'Tight End',
                'OL' => 'Offensive Line',
                'DL' => 'Defensive Line',
                'LB' => 'Linebacker',
                'DB' => 'Defensive Back',
                'K' => 'Kicker',
                'P' => 'Punter',
            ],
            'basketball' => [
                'PG' => 'Point Guard',
                'SG' => 'Shooting Guard',
                'SF' => 'Small Forward',
                'PF' => 'Power Forward',
                'C' => 'Center',
            ],
            'baseball' => [
                'P' => 'Pitcher',
                'C' => 'Catcher',
                '1B' => 'First Base',
                '2B' => 'Second Base',
                '3B' => 'Third Base',
                'SS' => 'Shortstop',
                'OF' => 'Outfield',
                'DH' => 'Designated Hitter',
            ],
            'track' => [
                'Sprints' => 'Sprints (100m, 200m, 400m)',
                'Distance' => 'Distance (800m, 1600m, 3200m)',
                'Hurdles' => 'Hurdles',
                'Jumps' => 'Jumps (High, Long, Triple)',
                'Throws' => 'Throws (Shot, Discus, Javelin)',
                'Relays' => 'Relays',
            ],
            'soccer' => [
                'GK' => 'Goalkeeper',
                'DEF' => 'Defender',
                'MID' => 'Midfielder',
                'FWD' => 'Forward',
            ],
            default => [],
        };
    }

    /**
     * Get stat fields for a specific sport
     */
    public static function getStatFields(string $sport): array
    {
        return match($sport) {
            'football' => [
                'games_played' => ['label' => 'Games Played', 'type' => 'number', 'required' => true],
                'receptions' => ['label' => 'Receptions', 'type' => 'number'],
                'receiving_yards' => ['label' => 'Receiving Yards', 'type' => 'number'],
                'yards_per_catch' => ['label' => 'Yards Per Catch', 'type' => 'number', 'step' => '0.1'],
                'touchdowns' => ['label' => 'Touchdowns', 'type' => 'number'],
                'rushing_yards' => ['label' => 'Rushing Yards', 'type' => 'number'],
                'tackles' => ['label' => 'Tackles', 'type' => 'number'],
            ],
            'basketball' => [
                'games_played' => ['label' => 'Games Played', 'type' => 'number', 'required' => true],
                'points_per_game' => ['label' => 'Points Per Game', 'type' => 'number', 'step' => '0.1'],
                'rebounds_per_game' => ['label' => 'Rebounds Per Game', 'type' => 'number', 'step' => '0.1'],
                'assists_per_game' => ['label' => 'Assists Per Game', 'type' => 'number', 'step' => '0.1'],
                'steals_per_game' => ['label' => 'Steals Per Game', 'type' => 'number', 'step' => '0.1'],
                'blocks_per_game' => ['label' => 'Blocks Per Game', 'type' => 'number', 'step' => '0.1'],
                'field_goal_pct' => ['label' => 'Field Goal %', 'type' => 'number', 'step' => '0.1'],
                'three_point_pct' => ['label' => '3-Point %', 'type' => 'number', 'step' => '0.1'],
            ],
            'baseball' => [
                'games_played' => ['label' => 'Games Played', 'type' => 'number', 'required' => true],
                'batting_avg' => ['label' => 'Batting Average', 'type' => 'number', 'step' => '0.001'],
                'home_runs' => ['label' => 'Home Runs', 'type' => 'number'],
                'rbis' => ['label' => 'RBIs', 'type' => 'number'],
                'stolen_bases' => ['label' => 'Stolen Bases', 'type' => 'number'],
                'era' => ['label' => 'ERA', 'type' => 'number', 'step' => '0.01'],
                'strikeouts' => ['label' => 'Strikeouts', 'type' => 'number'],
                'wins' => ['label' => 'Wins', 'type' => 'number'],
            ],
            'track' => [
                'events_competed' => ['label' => 'Events Competed', 'type' => 'number', 'required' => true],
                'best_time_100m' => ['label' => 'Best 100m Time', 'type' => 'text'],
                'best_time_200m' => ['label' => 'Best 200m Time', 'type' => 'text'],
                'best_time_400m' => ['label' => 'Best 400m Time', 'type' => 'text'],
                'best_time_800m' => ['label' => 'Best 800m Time', 'type' => 'text'],
                'best_time_1600m' => ['label' => 'Best 1600m Time', 'type' => 'text'],
                'best_long_jump' => ['label' => 'Best Long Jump', 'type' => 'text'],
                'best_high_jump' => ['label' => 'Best High Jump', 'type' => 'text'],
            ],
            'soccer' => [
                'games_played' => ['label' => 'Games Played', 'type' => 'number', 'required' => true],
                'goals' => ['label' => 'Goals', 'type' => 'number'],
                'assists' => ['label' => 'Assists', 'type' => 'number'],
                'shots_on_goal' => ['label' => 'Shots on Goal', 'type' => 'number'],
                'saves' => ['label' => 'Saves (GK)', 'type' => 'number'],
                'clean_sheets' => ['label' => 'Clean Sheets (GK)', 'type' => 'number'],
            ],
            default => [
                'games_played' => ['label' => 'Games/Events', 'type' => 'number', 'required' => true],
            ],
        };
    }

    /**
     * Get skill categories for a specific sport
     */
    public static function getSkills(string $sport): array
    {
        return match($sport) {
            'football' => [
                'Speed & Agility' => 85,
                'Route Running' => 85,
                'Hands & Catching' => 85,
                'Football IQ' => 85,
                'Leadership' => 85,
            ],
            'basketball' => [
                'Ball Handling' => 85,
                'Shooting' => 85,
                'Defense' => 85,
                'Basketball IQ' => 85,
                'Leadership' => 85,
            ],
            'baseball' => [
                'Hitting' => 85,
                'Fielding' => 85,
                'Throwing' => 85,
                'Baseball IQ' => 85,
                'Leadership' => 85,
            ],
            'track' => [
                'Speed' => 85,
                'Endurance' => 85,
                'Technique' => 85,
                'Mental Toughness' => 85,
                'Versatility' => 85,
            ],
            'soccer' => [
                'Ball Control' => 85,
                'Passing' => 85,
                'Defense' => 85,
                'Soccer IQ' => 85,
                'Leadership' => 85,
            ],
            default => [
                'Skill 1' => 85,
                'Skill 2' => 85,
                'Skill 3' => 85,
                'Skill 4' => 85,
                'Leadership' => 85,
            ],
        };
    }
}
