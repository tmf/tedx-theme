<?php
/**
 * @autor Tom Forrer <tom.forrer@gmail.com>
 */

$textDomain = wp_get_theme()->get('TextDomain');
?>
<form role="search" id="search-form" action="/" method="get">
    <div class="form-group search-group">
        <label for="search" class="sr-only"><?php _e('Search', $textDomain); ?></label>
        <input type="search" class="form-control" id="search" name="s" value="<?php echo get_query_var('s'); ?>"/>
        <button type="submit">
            <i class="icon icon__magnifying-glass"></i>
        </button>
    </div>

    <div class="form-group submit-group">
        <input type="submit" value="<?php _e('Search', $textDomain); ?>" class="form-control"/>
    </div>
</form>