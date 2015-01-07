<?php
/**
 * @autor Tom Forrer <tom.forrer@gmail.com>
 */

?>
<article <?php post_class(); ?> >
    <div class="row">
        <header class="col-xs-12 with-meta">
            <h1>
                <?php the_title(); ?>
            </h1>
            <aside class="post-meta">
                <span class="post-date">
                    <?php echo the_date(); ?>
                </span>
            </aside>
        </header>

        <div class="col-xs-12">
            <?php get_template_part('templates/content/post', 'content'); ?>
        </div>
    </div>
</article>