<?php
/**
 * Template Name: Full width page
 *
 * @autor Tom Forrer <tom.forrer@gmail.com>
 */

get_template_part('templates/partials/header'); ?>

    <div class="white-background col-md-12 clearfix">
        <div class="posts-column"><?php

            if (have_posts()):

                the_post();
                get_template_part('templates/content/page', 'single');

            else:
                get_template_part('templates/partials/not-found');
            endif; ?>
        </div>
    </div>

<?php get_template_part('templates/partials/footer');
