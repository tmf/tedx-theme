<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

use TEDxZurich\Theme\Widget\SocialMediaWidget;

/**
 * @var SocialMediaWidget $widget
 */
$widgetArguments = $widget->getWidgetArguments();
$instanceParameters = $widget->getInstanceParameters();

if (isset($instanceParameters['service']) && is_array($instanceParameters['service']) && count($instanceParameters['service']) > 0):
    echo $widgetArguments['before_widget'];
    if (strlen(trim($instanceParameters['title'])) > 0):
        ?><h3 class="widget-title"><?php echo $instanceParameters['title']; ?></h3><?php
    endif;
    ?>
    <ul><?php
    foreach ($instanceParameters['service'] as $index => $service):
        if (filter_var($instanceParameters['url'][$index], FILTER_VALIDATE_URL)): ?>
            <li class=""><a href="<?php echo $instanceParameters['url'][$index]; ?>"
                            class=""
                            target="_blank"
                            title="<?php echo $widget->getServiceDescription($service); ?>">
                    <i class="icon icon__<?php echo $service; ?>"></i>
                    <span class="label"><?php echo $widget->getServiceLabel($service); ?></span>
                </a></li>
        <?php endif;
    endforeach;
    ?></ul><?php

    echo $widgetArguments['after_widget'];
endif;