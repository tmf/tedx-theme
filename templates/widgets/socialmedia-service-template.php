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
$currentServiceIndex = $widget->getCurrentServiceIndex();
$currentService = isset($instanceParameters['service'][$currentServiceIndex]) ? $instanceParameters['service'][$currentServiceIndex] : '';
$currentUrl = isset($instanceParameters['url'][$currentServiceIndex]) ? $instanceParameters['url'][$currentServiceIndex] : '';
?>
<li class="service">
    <select name="<?php echo $widget->get_field_name('service'); ?>[]">

        <option value="" <?php selected($currentService, ''); ?>>Select a service</option>

        <?php foreach ($widget->getSupportedServices() as $service): ?>
            <option
                value="<?php echo $service; ?>"
                <?php selected($currentService, $service); ?>><?php
                echo $widget->getServiceLabel($service);
                ?></option>
        <?php endforeach; ?>

    </select>

    <input type="text"
           name="<?php echo $widget->get_field_name('url'); ?>[]"
           value="<?php echo esc_attr($currentUrl); ?>"
           placeholder="http://"
           class="url-field"/>

    <span class="dashicons dashicons-sort reorder-service" title="Drag and drop to reorder services"></span>
    <span class="dashicons dashicons-no-alt remove-service" title="Remove this service"></span>

</li>