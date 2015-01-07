<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 */

/**
 * @var WP_Query $wp_query
 */
$lastPage = $wp_query->max_num_pages;
$currentPage = get_query_var('paged') ? get_query_var('paged') : 1;
$range = 10;
$firstPage = max(1, $currentPage - $range);
?>

<nav role="navigation" class="clearfix col-xs-12">
    <ul class="pagination">

        <?php if ($currentPage != $firstPage): ?>
            <li><a href="<?php echo get_pagenum_link($currentPage - 1) ?>" aria-label="Previous"><span
                        aria-hidden="true">&lsaquo;</span></a></li>
        <?php endif; ?>
        <?php for ($page = $firstPage; $page <= $lastPage && $page <= $currentPage + $range; $page++): ?>
            <li class="<?php echo $currentPage == $page ? 'active': ''; ?>">
                <a href="<?php echo get_pagenum_link($page); ?>">
                    <?php echo $page; ?>
                </a>
            </li>
        <?php endfor; ?>
        <?php if ($currentPage != $lastPage): ?>
            <li><a href="<?php echo get_pagenum_link($currentPage + 1) ?>" aria-label="Next"><span
                        aria-hidden="true">&rsaquo;</span></a></li>
        <?php endif; ?>

    </ul>
    <span class="indicator"><?php printf('Page %d of %d', $currentPage, $lastPage); ?></span>
</nav>
