<?php
/**
 * @autor Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

get_template_part('templates/partials/header'); ?>

    <div class="container-md-height">
        <div class="white-background col-md-8 col-md-height clearfix">
            <div class="posts-column">

                <?php get_template_part('templates/partials/gcse'); ?>

            </div>
        </div>
        <?php get_template_part('templates/partials/sidebar'); ?>
    </div>


<?php get_template_part('templates/partials/footer');
