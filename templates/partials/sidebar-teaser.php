<?php
/**
 * @autor Tom Forrer <tom.forrer@gmail.com>
 */

if (is_active_sidebar('sidebar-teaser')): ?>
    <aside class="sidebar teaser col-md-12">
        <div class="row">
            <div class="container-md-height">
                <ul class="list-style-none row-md-height clearfix">
                    <?php dynamic_sidebar('sidebar-teaser'); ?>
                </ul>
            </div>
        </div>
    </aside>
<?php endif;