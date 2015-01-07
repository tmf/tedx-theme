<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

/**
 * @var WP_Query $talksQuery
 */
if ($talksQuery->have_posts()):
    ?><section class="talks row"><?php
    while ($talksQuery->have_posts()):
        $talksQuery->the_post();
        get_template_part('templates/content/talk', 'preview');
    endwhile;
    ?></section><?php
endif;
wp_reset_query();
