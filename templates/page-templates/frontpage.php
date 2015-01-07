<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */
/*
 * Template Name: Frontpage
 * Description: The front page template displays a slider
 */

/**
 * @var \TEDxZurich\Theme\FrontPage $frontPageService
 */
$frontPageService = $services['frontpage'];
$iFrameContents = $frontPageService->getIFrameContents();
get_template_part('templates/partials/header'); ?>
    <div class="col-md-12 ">
        <?php if (strlen($iFrameContents) > 0): ?>
            <?php echo $iFrameContents; ?>
        <?php else: ?>
            <div class="slider">
                <?php
                $featuredPostsQuery = $frontPageService->getFeaturedPostsQuery();
                while ($featuredPostsQuery->have_posts()):
                    $featuredPostsQuery->the_post();

                    get_template_part('templates/content/post', 'featured');

                endwhile;
                wp_reset_query();
                ?>

            </div>
        <?php endif; ?>
    </div>
    <div class="col-md-12">
        <div class="container-md-height">
            <div class="white-background col-md-8 col-md-height clearfix">
                <div class="posts-column clearfix"><?php

                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                            ?><article class="frontpage"><?php
                            the_content();
                            ?></article><?php
                        endwhile;
                    else:
                        get_template_part('templates/partials/not-found');
                    endif; ?>
                </div>
            </div>
            <?php get_template_part('templates/partials/sidebar'); ?>
        </div>
    </div>
<?php get_template_part('templates/partials/footer');