<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */
?>
<article class="speaker preview col-md-3 clear-md-3 col-sm-3 clear-sm-3 col-xs-6">
    <header>
        <h1>
            <a href="<?php the_permalink(); ?>" class="row">
                <div class="col-xs-12">
                    <?php the_post_thumbnail(); ?>
                </div>
                <div class="col-xs-12">
                    <span class="label"><?php the_title(); ?></span>
                </div>
            </a>
        </h1>
    </header>
</article>