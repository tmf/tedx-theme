<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

use TEDxZurich\Theme\Widget\SocialMediaWidget;

/**
 * @var SocialMediaWidget $widget
 */
$instanceParameters = $widget->getInstanceParameters();
?>
<div class="social-media-services widget-with-selects">
    <p>
        <label>
            <span>Title</span>
            <input type="text"
                   id="<?php echo $widget->get_field_id('title'); ?>"
                   name="<?php echo $widget->get_field_name('title'); ?>"
                   value="<?php echo $instanceParameters['title']; ?>"/>
        </label>

    </p>

    <ul class="services">
        <?php
        if (isset($instanceParameters['service']) && is_array($instanceParameters['service'])):
            foreach ($instanceParameters['service'] as $index => $service):
                $widget->setCurrentServiceIndex($index);
                echo $widget->renderTemplate($widget->getTemplate(), 'service-template');
            endforeach;
        endif;
        ?>
    </ul>
    <button class="button add-social-media-service right">Add social media service</button>
</div>
