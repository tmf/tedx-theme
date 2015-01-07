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
<article class="talk col-xs-6 col-sm-3">
    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
        <section class="post-image">
            <?php echo $imageService->getResponsiveAttachment(
                get_post_thumbnail_id(),
                'normal-2x',
                ['normal-2x', 'normal-3x', 'normal-4x'],
                [
                    '(min-width: 992px) calc(((940px * 2 / 3) - 2 * 20px ) / 4)',
                    '(min-width: 768px) calc((100vw  - 2 * 20px) / 4)',
                    'calc((100vw - 2 * 20px) / 2)',
                ]
            ); ?>
        </section>
        <div class="talk-title"><?php the_title(); ?></div>
    </a>
</article>