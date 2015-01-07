<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

/**
 * @var WP_Query $speakersQuery
 */
if ($speakersQuery->have_posts()):
    ?><section class="speakers row"><?php
    while ($speakersQuery->have_posts()):
        $speakersQuery->the_post();
        get_template_part('templates/content/speaker', 'preview');
    endwhile;
    ?></section><?php
endif;
wp_reset_query();
