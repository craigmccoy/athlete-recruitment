<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo e(url('/')); ?></loc>
        <lastmod><?php echo e(now()->toW3cString()); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    
    <?php if($athlete): ?>
    <url>
        <loc><?php echo e(url('/#about')); ?></loc>
        <lastmod><?php echo e($athlete->updated_at->toW3cString()); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    
    <url>
        <loc><?php echo e(url('/#stats')); ?></loc>
        <lastmod><?php echo e($athlete->updated_at->toW3cString()); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    
    <url>
        <loc><?php echo e(url('/#highlights')); ?></loc>
        <lastmod><?php echo e($athlete->updated_at->toW3cString()); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    
    <url>
        <loc><?php echo e(url('/#contact')); ?></loc>
        <lastmod><?php echo e(now()->toW3cString()); ?></lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endif; ?>
</urlset>
<?php /**PATH /var/www/html/resources/views/sitemap.blade.php ENDPATH**/ ?>