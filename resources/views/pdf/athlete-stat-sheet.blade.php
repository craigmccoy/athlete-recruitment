<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $athlete->name }} - Athletic Stat Sheet</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #333;
        }
        .header {
            background: #2563eb;
            color: white;
            padding: 15px;
            text-align: center;
            margin-bottom: 12px;
        }
        .header h1 {
            font-size: 24pt;
            margin-bottom: 6px;
            font-weight: bold;
        }
        .header .subtitle {
            font-size: 12pt;
            margin-bottom: 8px;
        }
        .header .contact {
            font-size: 10pt;
            margin-top: 10px;
        }
        .section {
            margin: 0 15px 12px 15px;
            page-break-inside: avoid;
        }
        .section-title {
            background: #2563eb;
            color: white;
            padding: 6px 12px;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .info-grid {
            margin-bottom: 10px;
            font-size: 0; /* Remove whitespace between inline-block elements */
        }
        .info-row {
            display: inline-block;
            width: 49%;
            vertical-align: top;
            margin-bottom: 4px;
            background: #f9fafb;
            border-left: 3px solid #e5e7eb;
            font-size: 9pt;
        }
        .info-label {
            display: inline-block;
            font-weight: bold;
            padding: 4px 8px;
            width: 45%;
            background: #f3f4f6;
            vertical-align: top;
        }
        .info-value {
            display: inline-block;
            padding: 4px 8px;
            width: 54%;
            vertical-align: top;
        }
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .stats-table th {
            background: #1e40af;
            color: white;
            padding: 6px;
            text-align: left;
            font-size: 9pt;
        }
        .stats-table td {
            padding: 4px 6px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 9pt;
        }
        .stats-table tr:nth-child(even) {
            background: #f9fafb;
        }
        .awards-grid {
            display: table;
            width: 100%;
        }
        .award-item {
            display: table-row;
        }
        .award-item div {
            display: table-cell;
            padding: 8px 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .award-year {
            width: 15%;
            font-weight: bold;
            color: #2563eb;
        }
        .bio {
            padding: 10px 12px;
            background: #f9fafb;
            border-left: 4px solid #2563eb;
            line-height: 1.4;
            font-size: 9pt;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 15px;
            font-size: 9pt;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        .qr-section {
            text-align: center;
            padding: 15px;
            background: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            margin: 10px 15px 40px 15px;
        }
        .qr-section img {
            display: block;
            margin: 0 auto;
            border: 1px solid #e5e7eb;
            padding: 5px;
            background: white;
        }
        .testimonial {
            padding: 8px 12px;
            background: #f9fafb;
            border-left: 3px solid #2563eb;
            margin-bottom: 8px;
            page-break-inside: avoid;
        }
        .testimonial-content {
            font-style: italic;
            color: #374151;
            margin-bottom: 8px;
            line-height: 1.5;
        }
        .testimonial-author {
            font-size: 10pt;
            color: #6b7280;
        }
        .testimonial-author strong {
            color: #1f2937;
        }
    </style>
</head>
<body>
    <!-- Header -->
    @php
        $sportProfile = $athlete->sportProfile();
    @endphp
    <div class="header">
        <h1>{{ $athlete->name }}</h1>
        <div class="subtitle">
            @if($sportProfile?->position){{ $sportProfile->position }}@endif
            @if($sportProfile?->jersey_number) | #{{ $sportProfile->jersey_number }}@endif
            @if($athlete->sport && $athlete->sport !== 'football') | {{ ucfirst($athlete->sport) }}@endif
            | Class of {{ $athlete->graduation_year }}
        </div>
        <div class="subtitle">{{ $athlete->school_name }}</div>
        <div class="contact">
            @if($athlete->location){{ $athlete->location }}@endif
            @if($athlete->location && ($athlete->email || $athlete->phone)) | @endif
            @if($athlete->email){{ $athlete->email }}@endif
            @if($athlete->email && $athlete->phone) | @endif
            @if($athlete->phone){{ $athlete->phone }}@endif
        </div>
    </div>

    <!-- About -->
    @if($athlete->story)
    <div class="section">
        <div class="section-title">ABOUT</div>
        <div class="bio">
            {{ $athlete->story }}
        </div>
    </div>
    @endif

    <!-- Physical Profile -->
    <div class="section">
        <div class="section-title">PHYSICAL PROFILE</div>
        <div class="info-grid">
            @if($athlete->height)
            <div class="info-row">
                <div class="info-label">Height</div>
                <div class="info-value">{{ $athlete->height }}</div>
            </div>
            @endif
            @if($athlete->weight)
            <div class="info-row">
                <div class="info-label">Weight</div>
                <div class="info-value">{{ $athlete->weight }} lbs</div>
            </div>
            @endif
            @if($sportProfile)
                @if($athlete->sport === 'football' && $sportProfile->forty_yard_dash)
                <div class="info-row">
                    <div class="info-label">40-Yard Dash</div>
                    <div class="info-value">{{ number_format($sportProfile->forty_yard_dash, 2) }} sec</div>
                </div>
                @endif
                @if($athlete->sport === 'football' && $sportProfile->vertical_jump)
                <div class="info-row">
                    <div class="info-label">Vertical Jump</div>
                    <div class="info-value">{{ number_format($sportProfile->vertical_jump, 1) }}"</div>
                </div>
                @endif
                @if($athlete->sport === 'football' && $sportProfile->bench_press)
                <div class="info-row">
                    <div class="info-label">Bench Press</div>
                    <div class="info-value">{{ number_format($sportProfile->bench_press, 0) }} lbs</div>
                </div>
                @endif
                @if(in_array($athlete->sport, ['basketball', 'soccer']) && $sportProfile->sprint_speed)
                <div class="info-row">
                    <div class="info-label">Sprint Speed</div>
                    <div class="info-value">{{ number_format($sportProfile->sprint_speed, 2) }} sec</div>
                </div>
                @endif
                @if($athlete->sport === 'basketball' && $sportProfile->vertical_jump)
                <div class="info-row">
                    <div class="info-label">Vertical Jump</div>
                    <div class="info-value">{{ number_format($sportProfile->vertical_jump, 1) }}"</div>
                </div>
                @endif
                @if($athlete->sport === 'basketball' && $sportProfile->wingspan)
                <div class="info-row">
                    <div class="info-label">Wingspan</div>
                    <div class="info-value">{{ number_format($sportProfile->wingspan, 1) }}"</div>
                </div>
                @endif
                @if($athlete->sport === 'baseball' && $sportProfile->sixty_yard_dash)
                <div class="info-row">
                    <div class="info-label">60-Yard Dash</div>
                    <div class="info-value">{{ number_format($sportProfile->sixty_yard_dash, 2) }} sec</div>
                </div>
                @endif
                @if($athlete->sport === 'baseball' && $sportProfile->exit_velocity)
                <div class="info-row">
                    <div class="info-label">Exit Velocity</div>
                    <div class="info-value">{{ number_format($sportProfile->exit_velocity, 0) }} mph</div>
                </div>
                @endif
                @if($athlete->sport === 'baseball' && $sportProfile->throwing_hand)
                <div class="info-row">
                    <div class="info-label">Throws</div>
                    <div class="info-value">{{ $sportProfile->throwing_hand }}</div>
                </div>
                @endif
                @if($athlete->sport === 'baseball' && $sportProfile->batting_stance)
                <div class="info-row">
                    <div class="info-label">Bats</div>
                    <div class="info-value">{{ $sportProfile->batting_stance }}</div>
                </div>
                @endif
                @if($athlete->sport === 'soccer' && $sportProfile->preferred_foot)
                <div class="info-row">
                    <div class="info-label">Preferred Foot</div>
                    <div class="info-value">{{ $sportProfile->preferred_foot }}</div>
                </div>
                @endif
            @endif
            @if($athlete->gpa)
            <div class="info-row">
                <div class="info-label">GPA</div>
                <div class="info-value">{{ number_format($athlete->gpa, 2) }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Career Statistics -->
    @if($seasonStats->isNotEmpty())
    <div class="section">
        <div class="section-title">CAREER STATISTICS</div>
        @php
            $sport = $athlete->sport ?? 'football';

            // Define sport-specific columns
            $statColumns = match($sport) {
                'basketball' => [
                    ['label' => 'Season', 'field' => 'season_year'],
                    ['label' => 'Games', 'field' => 'competitions'],
                    ['label' => 'PPG', 'field' => 'points_per_game'],
                    ['label' => 'RPG', 'field' => 'rebounds_per_game'],
                    ['label' => 'APG', 'field' => 'assists_per_game'],
                    ['label' => 'FG%', 'field' => 'field_goal_percentage'],
                ],
                'baseball' => [
                    ['label' => 'Season', 'field' => 'season_year'],
                    ['label' => 'Games', 'field' => 'competitions'],
                    ['label' => 'AVG', 'field' => 'batting_average'],
                    ['label' => 'HR', 'field' => 'home_runs'],
                    ['label' => 'RBI', 'field' => 'rbis'],
                    ['label' => 'SB', 'field' => 'stolen_bases'],
                ],
                'soccer' => [
                    ['label' => 'Season', 'field' => 'season_year'],
                    ['label' => 'Matches', 'field' => 'competitions'],
                    ['label' => 'Goals', 'field' => 'goals'],
                    ['label' => 'Assists', 'field' => 'assists'],
                    ['label' => 'Shots', 'field' => 'shots'],
                    ['label' => 'SOG', 'field' => 'shots_on_goal'],
                ],
                'track' => [
                    ['label' => 'Season', 'field' => 'season_year'],
                    ['label' => 'Meets', 'field' => 'competitions'],
                    ['label' => 'Best Time', 'field' => 'best_time'],
                    ['label' => 'PR', 'field' => 'personal_record'],
                    ['label' => 'Medals', 'field' => 'medals'],
                ],
                default => [ // Football
                    ['label' => 'Season', 'field' => 'season_year'],
                    ['label' => 'Games', 'field' => 'competitions'],
                    ['label' => 'Rec', 'field' => 'receptions'],
                    ['label' => 'Yards', 'field' => 'receiving_yards'],
                    ['label' => 'YPC', 'field' => 'yards_per_catch'],
                    ['label' => 'TD', 'field' => 'touchdowns'],
                ],
            };
        @endphp

        <table class="stats-table">
            <thead>
                <tr>
                    @foreach($statColumns as $column)
                        <th>{{ $column['label'] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($seasonStats as $stat)
                <tr>
                    @foreach($statColumns as $column)
                        <td>
                            @if($column['field'] === 'season_year')
                                <strong>{{ $stat->{$column['field']} }}</strong>
                            @elseif(in_array($column['field'], ['yards_per_catch', 'batting_average', 'field_goal_percentage', 'gpa']))
                                {{ $stat->{$column['field']} ? number_format($stat->{$column['field']}, 2) : '-' }}
                            @elseif(in_array($column['field'], ['points_per_game', 'rebounds_per_game', 'assists_per_game']))
                                {{ $stat->{$column['field']} ? number_format($stat->{$column['field']}, 1) : '-' }}
                            @elseif($column['field'] === 'receiving_yards' || $column['field'] === 'rushing_yards')
                                {{ $stat->{$column['field']} ? number_format($stat->{$column['field']}) : '-' }}
                            @else
                                {{ $stat->{$column['field']} ?? '-' }}
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach

                @php
                    // Calculate career totals based on sport
                    $totals = ['competitions' => $seasonStats->sum('competitions')];

                    if ($sport === 'football') {
                        $totals['receptions'] = $seasonStats->sum('receptions');
                        $totals['yards'] = $seasonStats->sum('receiving_yards');
                        $totals['touchdowns'] = $seasonStats->sum('touchdowns');
                        $totals['ypc'] = $totals['receptions'] > 0 ? $totals['yards'] / $totals['receptions'] : 0;
                    } elseif ($sport === 'basketball') {
                        $totals['ppg'] = $seasonStats->avg('points_per_game');
                        $totals['rpg'] = $seasonStats->avg('rebounds_per_game');
                        $totals['apg'] = $seasonStats->avg('assists_per_game');
                        $totals['fg_pct'] = $seasonStats->avg('field_goal_percentage');
                    } elseif ($sport === 'baseball') {
                        $totals['avg'] = $seasonStats->avg('batting_average');
                        $totals['hr'] = $seasonStats->sum('home_runs');
                        $totals['rbi'] = $seasonStats->sum('rbis');
                        $totals['sb'] = $seasonStats->sum('stolen_bases');
                    } elseif ($sport === 'soccer') {
                        $totals['goals'] = $seasonStats->sum('goals');
                        $totals['assists'] = $seasonStats->sum('assists');
                        $totals['shots'] = $seasonStats->sum('shots');
                        $totals['sog'] = $seasonStats->sum('shots_on_goal');
                    }
                @endphp

                <tr style="background: #dbeafe; font-weight: bold;">
                    <td>CAREER</td>
                    <td>{{ $totals['competitions'] }}</td>
                    @if($sport === 'football')
                        <td>{{ $totals['receptions'] }}</td>
                        <td>{{ number_format($totals['yards']) }}</td>
                        <td>{{ number_format($totals['ypc'], 1) }}</td>
                        <td>{{ $totals['touchdowns'] }}</td>
                    @elseif($sport === 'basketball')
                        <td>{{ number_format($totals['ppg'], 1) }}</td>
                        <td>{{ number_format($totals['rpg'], 1) }}</td>
                        <td>{{ number_format($totals['apg'], 1) }}</td>
                        <td>{{ number_format($totals['fg_pct'], 1) }}%</td>
                    @elseif($sport === 'baseball')
                        <td>{{ number_format($totals['avg'], 3) }}</td>
                        <td>{{ $totals['hr'] }}</td>
                        <td>{{ $totals['rbi'] }}</td>
                        <td>{{ $totals['sb'] }}</td>
                    @elseif($sport === 'soccer')
                        <td>{{ $totals['goals'] }}</td>
                        <td>{{ $totals['assists'] }}</td>
                        <td>{{ $totals['shots'] }}</td>
                        <td>{{ $totals['sog'] }}</td>
                    @elseif($sport === 'track')
                        <td colspan="4" style="text-align: center;">-</td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    <!-- Awards & Honors -->
    @if($awards->isNotEmpty())
    <div class="section">
        <div class="section-title">AWARDS & HONORS</div>
        <div class="awards-grid">
            @foreach($awards as $award)
            <div class="award-item">
                <div class="award-year">{{ $award->year }}</div>
                <div>
                    <strong>{{ $award->title }}</strong>
                    @if($award->description)
                    <br><span style="color: #6b7280;">{{ $award->description }}</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Testimonials & Recommendations -->
    @php
        $featuredTestimonials = $testimonials->where('is_featured', true);
    @endphp
    @if($featuredTestimonials->isNotEmpty())
    <div class="section">
        <div class="section-title">TESTIMONIALS & RECOMMENDATIONS</div>
        @foreach($featuredTestimonials as $testimonial)
        <div class="testimonial">
            <div class="testimonial-content">
                "{{ $testimonial->content }}"
            </div>
            <div class="testimonial-author">
                <strong>{{ $testimonial->author_name }}</strong>
                @if($testimonial->author_title) - {{ $testimonial->author_title }}@endif
                @if($testimonial->author_organization), {{ $testimonial->author_organization }}@endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- QR Code Section -->
    <div class="qr-section">
        <img src="{{ $qrCodeDataUri }}" alt="QR Code" style="width: 120px; height: 120px;">
        <p style="font-size: 11pt; font-weight: bold; color: #1f2937; margin-top: 10px;">Scan to View Full Profile Online</p>
        <p style="font-size: 9pt; font-weight: normal; color: #6b7280; margin-top: 5px;">{{ url('/') }}</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        Generated on {{ now()->format('F j, Y') }} | {{ $athlete->name }} - Athletic Stat Sheet
    </div>
</body>
</html>
