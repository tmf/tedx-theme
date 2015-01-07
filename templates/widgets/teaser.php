<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

use TEDxZurich\Theme\Widget\TeaserWidget;

/**
 * @var TeaserWidget $widget
 */
$widgetArguments = $widget->getWidgetArguments();
$instanceParameters = $widget->getInstanceParameters();

$validUrl = filter_var($instanceParameters['url'], FILTER_VALIDATE_URL);
$hasIcon = !empty($instanceParameters['type']);

echo $widgetArguments['before_widget']; ?>

    <div class="teaser-box type-<?php echo $instanceParameters['type']; ?>"></div>
    <div
        class="teaser-widget-content clearfix type-<?php echo $instanceParameters['type']; ?> <?php echo $validUrl ? '' : 'without-url'; ?>">
        <?php if ($validUrl): ?><a href="<?php echo $instanceParameters['url']; ?>"
                                   title="<?php echo $instanceParameters['title']; ?>"
                                   class="clearfix"><?php endif; ?>

            <?php if ($hasIcon): ?>
                <i class="icon icon__<?php echo $instanceParameters['type']; ?>"></i>
            <?php endif; ?>

            <h3 class="widget-title"><?php echo $instanceParameters['title']; ?></h3>

            <?php if ($instanceParameters['type'] != 'alert'): ?>
                <p><?php echo $instanceParameters['text']; ?></p>
            <?php endif; ?>

            <?php if ($validUrl): ?></a><?php endif; ?>
    </div>

<?php echo $widgetArguments['after_widget']; ?>