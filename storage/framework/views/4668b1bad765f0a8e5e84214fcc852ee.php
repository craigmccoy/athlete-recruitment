<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($athlete->name); ?> - Athletic Resume</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
        }
        .header {
            background: #2563eb;
            color: white;
            padding: 30px;
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 28pt;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .header .subtitle {
            font-size: 14pt;
            margin-bottom: 15px;
        }
        .header .contact {
            font-size: 10pt;
            margin-top: 10px;
        }
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .section-title {
            background: #2563eb;
            color: white;
            padding: 8px 15px;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 5px 10px 5px 15px;
            width: 35%;
            background: #f3f4f6;
        }
        .info-value {
            display: table-cell;
            padding: 5px 15px;
            background: #f9fafb;
        }
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .stats-table th {
            background: #1e40af;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10pt;
        }
        .stats-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10pt;
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
            padding: 15px;
            background: #f9fafb;
            border-left: 4px solid #2563eb;
            line-height: 1.6;
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
            padding: 25px 20px;
            background: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            margin-top: 20px;
            margin-bottom: 60px;
        }
        .qr-section img {
            display: block;
            margin: 0 auto;
            border: 1px solid #e5e7eb;
            padding: 5px;
            background: white;
        }
        .testimonial {
            padding: 12px 15px;
            background: #f9fafb;
            border-left: 3px solid #2563eb;
            margin-bottom: 12px;
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
    <div class="header">
        <h1><?php echo e($athlete->name); ?></h1>
        <div class="subtitle">
            <?php echo e($athlete->position); ?><?php if($athlete->jersey_number): ?> | #<?php echo e($athlete->jersey_number); ?><?php endif; ?>
            <?php if($athlete->sport && $athlete->sport !== 'football'): ?> | <?php echo e(ucfirst($athlete->sport)); ?><?php endif; ?>
            | Class of <?php echo e($athlete->graduation_year); ?>

        </div>
        <div class="subtitle"><?php echo e($athlete->school_name); ?></div>
        <?php if($athlete->location): ?>
        <div class="contact"><?php echo e($athlete->location); ?></div>
        <?php endif; ?>
        <div class="contact">
            <?php if($athlete->email): ?><?php echo e($athlete->email); ?><?php endif; ?>
            <?php if($athlete->email && $athlete->phone): ?> | <?php endif; ?>
            <?php if($athlete->phone): ?><?php echo e($athlete->phone); ?><?php endif; ?>
        </div>
    </div>

    <!-- Physical Profile -->
    <div class="section">
        <div class="section-title">PHYSICAL PROFILE</div>
        <div class="info-grid">
            <?php if($athlete->height): ?>
            <div class="info-row">
                <div class="info-label">Height</div>
                <div class="info-value"><?php echo e($athlete->height); ?></div>
            </div>
            <?php endif; ?>
            <?php if($athlete->weight): ?>
            <div class="info-row">
                <div class="info-label">Weight</div>
                <div class="info-value"><?php echo e($athlete->weight); ?> lbs</div>
            </div>
            <?php endif; ?>
            <?php if($athlete->forty_time): ?>
            <div class="info-row">
                <?php
                    $speedLabel = match($athlete->sport ?? 'football') {
                        'basketball' => 'Sprint Speed',
                        'baseball' => '60-Yard Dash',
                        'soccer' => 'Sprint Speed',
                        'track' => 'Best Time',
                        default => '40-Yard Dash',
                    };
                ?>
                <div class="info-label"><?php echo e($speedLabel); ?></div>
                <div class="info-value"><?php echo e(number_format($athlete->forty_time, 2)); ?> seconds</div>
            </div>
            <?php endif; ?>
            <?php if($athlete->gpa): ?>
            <div class="info-row">
                <div class="info-label">GPA</div>
                <div class="info-value"><?php echo e(number_format($athlete->gpa, 2)); ?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Career Statistics -->
    <?php if($seasonStats->isNotEmpty()): ?>
    <div class="section">
        <div class="section-title">CAREER STATISTICS</div>
        <?php
            $sport = $athlete->sport ?? 'football';

            // Define sport-specific columns
            $statColumns = match($sport) {
                'basketball' => [
                    ['label' => 'Season', 'field' => 'season_year'],
                    ['label' => 'Games', 'field' => 'games_played'],
                    ['label' => 'PPG', 'field' => 'points_per_game'],
                    ['label' => 'RPG', 'field' => 'rebounds_per_game'],
                    ['label' => 'APG', 'field' => 'assists_per_game'],
                    ['label' => 'FG%', 'field' => 'field_goal_percentage'],
                ],
                'baseball' => [
                    ['label' => 'Season', 'field' => 'season_year'],
                    ['label' => 'Games', 'field' => 'games_played'],
                    ['label' => 'AVG', 'field' => 'batting_average'],
                    ['label' => 'HR', 'field' => 'home_runs'],
                    ['label' => 'RBI', 'field' => 'rbis'],
                    ['label' => 'SB', 'field' => 'stolen_bases'],
                ],
                'soccer' => [
                    ['label' => 'Season', 'field' => 'season_year'],
                    ['label' => 'Games', 'field' => 'games_played'],
                    ['label' => 'Goals', 'field' => 'goals'],
                    ['label' => 'Assists', 'field' => 'assists'],
                    ['label' => 'Shots', 'field' => 'shots'],
                    ['label' => 'SOG', 'field' => 'shots_on_goal'],
                ],
                'track' => [
                    ['label' => 'Season', 'field' => 'season_year'],
                    ['label' => 'Events', 'field' => 'events_competed'],
                    ['label' => 'Best Time', 'field' => 'best_time'],
                    ['label' => 'PR', 'field' => 'personal_record'],
                    ['label' => 'Medals', 'field' => 'medals'],
                ],
                default => [ // Football
                    ['label' => 'Season', 'field' => 'season_year'],
                    ['label' => 'Games', 'field' => 'games_played'],
                    ['label' => 'Rec', 'field' => 'receptions'],
                    ['label' => 'Yards', 'field' => 'receiving_yards'],
                    ['label' => 'YPC', 'field' => 'yards_per_catch'],
                    ['label' => 'TD', 'field' => 'touchdowns'],
                ],
            };
        ?>

        <table class="stats-table">
            <thead>
                <tr>
                    <?php $__currentLoopData = $statColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e($column['label']); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $seasonStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <?php $__currentLoopData = $statColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td>
                            <?php if($column['field'] === 'season_year'): ?>
                                <strong><?php echo e($stat->{$column['field']}); ?></strong>
                            <?php elseif(in_array($column['field'], ['yards_per_catch', 'batting_average', 'field_goal_percentage', 'gpa'])): ?>
                                <?php echo e($stat->{$column['field']} ? number_format($stat->{$column['field']}, 2) : '-'); ?>

                            <?php elseif(in_array($column['field'], ['points_per_game', 'rebounds_per_game', 'assists_per_game'])): ?>
                                <?php echo e($stat->{$column['field']} ? number_format($stat->{$column['field']}, 1) : '-'); ?>

                            <?php elseif($column['field'] === 'receiving_yards' || $column['field'] === 'rushing_yards'): ?>
                                <?php echo e($stat->{$column['field']} ? number_format($stat->{$column['field']}) : '-'); ?>

                            <?php else: ?>
                                <?php echo e($stat->{$column['field']} ?? '-'); ?>

                            <?php endif; ?>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php
                    // Calculate career totals based on sport
                    $totals = ['games' => $seasonStats->sum('games_played')];

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
                ?>

                <tr style="background: #dbeafe; font-weight: bold;">
                    <td>CAREER</td>
                    <td><?php echo e($totals['games']); ?></td>
                    <?php if($sport === 'football'): ?>
                        <td><?php echo e($totals['receptions']); ?></td>
                        <td><?php echo e(number_format($totals['yards'])); ?></td>
                        <td><?php echo e(number_format($totals['ypc'], 1)); ?></td>
                        <td><?php echo e($totals['touchdowns']); ?></td>
                    <?php elseif($sport === 'basketball'): ?>
                        <td><?php echo e(number_format($totals['ppg'], 1)); ?></td>
                        <td><?php echo e(number_format($totals['rpg'], 1)); ?></td>
                        <td><?php echo e(number_format($totals['apg'], 1)); ?></td>
                        <td><?php echo e(number_format($totals['fg_pct'], 1)); ?>%</td>
                    <?php elseif($sport === 'baseball'): ?>
                        <td><?php echo e(number_format($totals['avg'], 3)); ?></td>
                        <td><?php echo e($totals['hr']); ?></td>
                        <td><?php echo e($totals['rbi']); ?></td>
                        <td><?php echo e($totals['sb']); ?></td>
                    <?php elseif($sport === 'soccer'): ?>
                        <td><?php echo e($totals['goals']); ?></td>
                        <td><?php echo e($totals['assists']); ?></td>
                        <td><?php echo e($totals['shots']); ?></td>
                        <td><?php echo e($totals['sog']); ?></td>
                    <?php elseif($sport === 'track'): ?>
                        <td colspan="4" style="text-align: center;">-</td>
                    <?php endif; ?>
                </tr>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Awards & Honors -->
    <?php if($awards->isNotEmpty()): ?>
    <div class="section">
        <div class="section-title">AWARDS & HONORS</div>
        <div class="awards-grid">
            <?php $__currentLoopData = $awards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="award-item">
                <div class="award-year"><?php echo e($award->year); ?></div>
                <div>
                    <strong><?php echo e($award->title); ?></strong>
                    <?php if($award->description): ?>
                    <br><span style="color: #6b7280;"><?php echo e($award->description); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Testimonials & Recommendations -->
    <?php if($testimonials->isNotEmpty()): ?>
    <div class="section">
        <div class="section-title">TESTIMONIALS & RECOMMENDATIONS</div>
        <?php $__currentLoopData = $testimonials->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="testimonial">
            <div class="testimonial-content">
                "<?php echo e($testimonial->content); ?>"
            </div>
            <div class="testimonial-author">
                <strong><?php echo e($testimonial->author_name); ?></strong>
                <?php if($testimonial->author_title): ?> - <?php echo e($testimonial->author_title); ?><?php endif; ?>
                <?php if($testimonial->author_organization): ?>, <?php echo e($testimonial->author_organization); ?><?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <!-- About -->
    <?php if($athlete->story): ?>
    <div class="section">
        <div class="section-title">ABOUT</div>
        <div class="bio">
            <?php echo e($athlete->story); ?>

        </div>
    </div>
    <?php endif; ?>

    <!-- QR Code Section -->
    <div class="qr-section">
        <img src="<?php echo e($qrCodeDataUri); ?>" alt="QR Code" style="width: 120px; height: 120px;">
        <p style="font-size: 11pt; font-weight: bold; color: #1f2937; margin-top: 10px;">Scan to View Full Profile Online</p>
        <p style="font-size: 9pt; font-weight: normal; color: #6b7280; margin-top: 5px;"><?php echo e(url('/')); ?></p>
    </div>

    <!-- Footer -->
    <div class="footer">
        Generated on <?php echo e(now()->format('F j, Y')); ?> | <?php echo e($athlete->name); ?> - Athletic Stat Sheet
    </div>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/pdf/athlete-resume.blade.php ENDPATH**/ ?>