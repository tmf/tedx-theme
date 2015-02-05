<?php
/**
 * @autor Tom Forrer <tom.forrer@gmail.com>
 */

?>
<article <?php post_class(); ?> >
    <div class="row">
        <header class="col-xs-12">
            <h1>
                <?php the_title(); ?>
            </h1>
        </header>
        <?php
        echo $services['posts']->renderPostsFromQuery($services['talks']->getTalksBySpeakerQuery(get_the_ID()));
        ?>

        <div class="col-xs-12">
            <?php get_template_part('templates/content/post', 'content'); ?>
        </div>
    </div>
</article>