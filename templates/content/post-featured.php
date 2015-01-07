<?php
/**
 * @autor Tom Forrer <tom.forrer@gmail.com>
 */

use TEDxZurich\Theme\Images;

/**
 * @var Images $imageService
 */
$imageService = $services['images'];
?>
<article class="post">
    <div class="row">

        <section class="post-image col-xs-12">
            <?php echo $imageService->getResponsiveAttachment(
                get_post_thumbnail_id(),
                'wide-5x',
                ['wide-2x', 'wide-3x', 'wide-4x', 'wide-5x', 'wide-10x'],
                [
                    'calc(100vw - 2 * 20px)',
                ]
            ); ?>
        </section>
        <header class="col-xs-12">
            <h1>
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h1>
            <?php the_excerpt(); ?>
            <a href="<?php the_permalink(); ?>"
               title="<?php printf('Continue reading &laquo;%s&raquo;', get_the_title()); ?>">Continue
                reading &rsaquo;</a>
        </header>

    </div>
</article>