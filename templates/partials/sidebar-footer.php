<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 */

?>
<footer class="sidebar footer col-md-12">
    <div class="box">
        <ul class="list-style-none row">

            <?php dynamic_sidebar('sidebar-footer'); ?>

            <li class="widget col-md-2 col-sm-4 col-xs-6 pull-right">
                <a href="#" rel="home" class="home">
                    <img src="<?php echo $services['assets']->resolveUri('resources/images/logo.png'); ?>"
                         class="logo"
                         alt="TEDx Logo"/>
                </a>
            </li>
        </ul>
    </div>
</footer>