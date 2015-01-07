<?php
/**
 * @autor Tom Forrer <tom.forrer@gmail.com>
 */

use TEDxZurich\Theme\Images;

/**
 * @var Images $imageService
 */
$imageService = $services['images'];

$theDate = the_date('', '','', false);
?>
<article class="post">
    <div class="row">
        <header class="col-xs-12 <?php echo empty($theDate) ? '': 'with-meta'; ?>">
            <h1>
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h1>
            <?php if (!empty($theDate)): ?>
                <aside class="post-meta">
            <span class="post-date">
                <?php echo $theDate; ?>
            </span>
                </aside>
            <?php endif; ?>
        </header>
        <section class="post-image col-xs-12 col-sm-4 col-sm-push-8 col-md-6 col-md-push-0">
            <?php echo $imageService->getResponsiveAttachment(
                get_post_thumbnail_id(),
                'wide-2x',
                ['wide-2x', 'wide-3x', 'wide-4x', 'wide-5x', 'wide-10x'],
                [
                    '(min-width: 992px) calc(((940px * 2 / 3) - 2 * 20px ) / 2)',
                    '(min-width: 768px) calc((100vw  - 2 * 20px ) / 3)',
                    'calc(100vw - 2 * 20px)',
                ]
            ); ?>
        </section>
        <section class="post-excerpt col-xs-12 col-sm-8 col-sm-pull-4 col-md-6 col-md-pull-0">
            <div class="text-padding">
                <?php the_excerpt(); ?>
                <a href="<?php the_permalink(); ?>"
                   title="<?php printf('Continue reading &laquo;%s&raquo;', get_the_title()); ?>">Continue
                    reading &rsaquo;</a>
            </div>
        </section>
    </div>
</article>