<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */
use TEDxZurich\Theme\Widget\SpeakersWidget;
use TEDxZurich\Theme\Editions;

/**
 * @var SpeakersWidget $widget
 */
$instanceParameters = $widget->getInstanceParameters();


/**
 * @var Editions $editionsService
 */
$editionsService = $widget->getContainer()['editions'];
?>
<div class="speakers-widget-options widget-with-selects">
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
            <span>Speakers from edition</span>
            <?php echo $editionsService->getEditionsDropdown($instanceParameters['edition'], false, $widget->get_field_name('edition')); ?>
        </label>
    </p>

    <p>
        <label>
            <span>Number of Speakers to display</span>
            <input type="text"
                   name="<?php echo $widget->get_field_name('number'); ?>"
                   value="<?php echo $instanceParameters['number']; ?>"/>
        </label>

    </p>

    <p>
        <label>
            <input type="checkbox"
                   name="<?php echo $widget->get_field_name('archive'); ?>"
                <?php checked($instanceParameters['archive'], 'on'); ?> />
            <span>Display archive Link</span>
        </label>

    </p>
</div>