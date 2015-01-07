<?php
/**
 * @autor Tom Forrer <tom.forrer@gmail.com>
 */


?><aside class="sidebar top col-md-12" id="sidebar-top">
    <ul class="list-style-none row">
        <?php dynamic_sidebar('sidebar-top'); ?>
        <li class="widget search-widget col-md-4 pull-right">
            <?php get_template_part('templates/partials/search-form'); ?>
        </li>
    </ul>
</aside>