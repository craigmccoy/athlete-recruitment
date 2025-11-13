<section id="stats" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Career Statistics</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
        </div>

        <!-- Loading Skeleton -->
        <div wire:loading class="animate-pulse">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < 4; $i++): ?>
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="h-10 bg-gray-200 rounded mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4 mx-auto mb-1"></div>
                    <div class="h-3 bg-gray-200 rounded w-1/2 mx-auto"></div>
                </div>
                <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="h-6 bg-gray-200 rounded w-1/3 mb-6"></div>
                <div class="space-y-4">
                    <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < 3; $i++): ?>
                    <div class="h-12 bg-gray-200 rounded"></div>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>

        <!-- Actual Content -->
        <div wire:loading.remove>
        <!-- Season Stats -->
        <!--[if BLOCK]><![endif]--><?php if($seasonStats->isNotEmpty()): ?>
            <?php 
                $currentSeason = $seasonStats->first(); 
                $sport = $athlete?->sport ?? 'football';
                
                // Get top 4 stats to display based on sport
                $highlightStats = match($sport) {
                    'basketball' => [
                        ['value' => number_format($currentSeason->points_per_game ?? 0, 1), 'label' => 'Points Per Game'],
                        ['value' => number_format($currentSeason->rebounds_per_game ?? 0, 1), 'label' => 'Rebounds Per Game'],
                        ['value' => number_format($currentSeason->assists_per_game ?? 0, 1), 'label' => 'Assists Per Game'],
                        ['value' => number_format($currentSeason->field_goal_percentage ?? 0, 1) . '%', 'label' => 'Field Goal %'],
                    ],
                    'baseball' => [
                        ['value' => number_format($currentSeason->batting_average ?? 0, 3), 'label' => 'Batting Average'],
                        ['value' => $currentSeason->home_runs ?? 0, 'label' => 'Home Runs'],
                        ['value' => $currentSeason->rbis ?? 0, 'label' => 'RBIs'],
                        ['value' => $currentSeason->stolen_bases ?? 0, 'label' => 'Stolen Bases'],
                    ],
                    'soccer' => [
                        ['value' => $currentSeason->goals ?? 0, 'label' => 'Goals'],
                        ['value' => $currentSeason->assists ?? 0, 'label' => 'Assists'],
                        ['value' => $currentSeason->shots ?? 0, 'label' => 'Shots'],
                        ['value' => $currentSeason->shots_on_goal ?? 0, 'label' => 'Shots on Goal'],
                    ],
                    'track' => [
                        ['value' => $currentSeason->best_time ?? 'N/A', 'label' => 'Best Time'],
                        ['value' => $currentSeason->personal_record ?? 'N/A', 'label' => 'Personal Record'],
                        ['value' => $currentSeason->medals ?? 0, 'label' => 'Medals'],
                        ['value' => $currentSeason->competitions ?? 0, 'label' => 'Meets'],
                    ],
                    default => [ // Football
                        ['value' => number_format($currentSeason->receiving_yards ?? 0), 'label' => 'Receiving Yards'],
                        ['value' => $currentSeason->touchdowns ?? 0, 'label' => 'Touchdowns'],
                        ['value' => $currentSeason->receptions ?? 0, 'label' => 'Receptions'],
                        ['value' => number_format($currentSeason->yards_per_catch ?? 0, 1), 'label' => 'Yards Per Catch'],
                    ],
                };
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $highlightStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl shadow-lg p-6 text-center transform hover:scale-105 hover:shadow-2xl transition-all duration-300">
                    <div class="text-4xl font-bold text-blue-600 mb-2"><?php echo e($stat['value']); ?></div>
                    <div class="text-gray-600 font-medium"><?php echo e($stat['label']); ?></div>
                    <div class="text-sm text-gray-500 mt-1"><?php echo e($currentSeason->season_year); ?> Season</div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

        <!-- Detailed Stats Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-blue-600 text-white">
                <h3 class="text-xl font-bold">Season by Season Breakdown</h3>
            </div>
            <div class="overflow-x-auto">
                <?php
                    // Define table columns based on sport
                    $tableColumns = match($sport) {
                        'basketball' => ['Season', 'Games', 'PPG', 'RPG', 'APG', 'FG%'],
                        'baseball' => ['Season', 'Games', 'AVG', 'HR', 'RBI', 'SB'],
                        'soccer' => ['Season', 'Matches', 'Goals', 'Assists', 'Shots', 'SOG'],
                        'track' => ['Season', 'Meets', 'Best Time', 'PR', 'Medals'],
                        default => ['Season', 'Games', 'Rec', 'Yards', 'YPC', 'TD'],
                    };
                ?>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tableColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e($column); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $seasonStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo e($stat->season_year); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->competitions); ?></td>
                            <!--[if BLOCK]><![endif]--><?php if($sport === 'football'): ?>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->receptions ?? 0); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e(number_format($stat->receiving_yards ?? 0)); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e(number_format($stat->yards_per_catch ?? 0, 1)); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->touchdowns ?? 0); ?></td>
                            <?php elseif($sport === 'basketball'): ?>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e(number_format($stat->points_per_game ?? 0, 1)); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e(number_format($stat->rebounds_per_game ?? 0, 1)); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e(number_format($stat->assists_per_game ?? 0, 1)); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e(number_format($stat->field_goal_percentage ?? 0, 1)); ?>%</td>
                            <?php elseif($sport === 'baseball'): ?>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e(number_format($stat->batting_average ?? 0, 3)); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->home_runs ?? 0); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->rbis ?? 0); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->stolen_bases ?? 0); ?></td>
                            <?php elseif($sport === 'soccer'): ?>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->goals ?? 0); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->assists ?? 0); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->shots ?? 0); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->shots_on_goal ?? 0); ?></td>
                            <?php elseif($sport === 'track'): ?>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->best_time ?? 'N/A'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->personal_record ?? 'N/A'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->medals ?? 0); ?></td>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
        <!-- Empty State for Stats -->
        <div class="bg-white rounded-xl shadow-lg px-12 py-20 text-center">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Stats Coming Soon</h3>
            <p class="text-gray-600 max-w-md mx-auto">Season statistics will be available once games begin. Check back during the season!</p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div><!-- End wire:loading.remove -->

        <!-- Awards & Honors -->
        <!--[if BLOCK]><![endif]--><?php if($awards->isNotEmpty()): ?>
        <div id="awards" class="mt-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Awards & Honors</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $awards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gradient-to-br from-<?php echo e($award->color); ?>-50 to-<?php echo e($award->color); ?>-100 rounded-xl p-6 border-2 border-<?php echo e($award->color); ?>-300">
                <div class="text-3xl mb-2"><?php echo e($award->icon); ?></div>
                <h4 class="font-bold text-gray-900 mb-1"><?php echo e($award->title); ?></h4>
                <!--[if BLOCK]><![endif]--><?php if($award->year): ?>
                <p class="text-sm font-semibold text-gray-700 mb-1"><?php echo e($award->year); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!--[if BLOCK]><![endif]--><?php if($award->description): ?>
                <p class="text-sm text-gray-600"><?php echo e($award->description); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</section>
<?php /**PATH /var/www/html/resources/views/livewire/stats-section.blade.php ENDPATH**/ ?>