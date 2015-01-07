<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

use TEDxZurich\Theme\Widget\TeaserWidget;

/**
 * @var TeaserWidget $widget
 */
$instanceParameters = $widget->getInstanceParameters();
?>
<div class="teaser-widget-options widget-with-selects type-<?php echo $instanceParameters['type']; ?>">
    <p>
        <label>
            <span>Title</span>
            <input type="text"
                   id="<?php echo $widget->get_field_id('title'); ?>"
                   name="<?php echo $widget->get_field_name('title'); ?>"
                   value="<?php echo $instanceParameters['title']; ?>"/>
        </label>
    </p>

    <p>
        <label>
            <span>Teaser Widget type</span>
            <select name="<?php echo $widget->get_field_name('type'); ?>">
                <option value="" <?php selected($instanceParameters['type'], ''); ?>>Select display type</option>
                <option value="calendar"<?php selected($instanceParameters['type'], 'calendar'); ?>>Calendar</option>
                <option value="venue"<?php selected($instanceParameters['type'], 'venue'); ?>>Venue</option>
                <option value="alert"<?php selected($instanceParameters['type'], 'alert'); ?>>Alert</option>
            </select>
        </label>
    </p

    <p>
        <label>
            <span>Teaser Link</span>
            <input type="text"
                   name="<?php echo $widget->get_field_name('url'); ?>"
                   value="<?php echo $instanceParameters['url']; ?>"
                   placeholder="http://"/>
            <span class="hint">Leaving the link field blank will just display the unlinked teaser widget</span>
        </label>
    </p>

    <p class="form-group teaser-text">
        <label>
            <span>Teaser text</span>
            <textarea
                name="<?php echo $widget->get_field_name('text'); ?>"><?php echo $instanceParameters['text']; ?></textarea>
        </label>

    </p>
</div>