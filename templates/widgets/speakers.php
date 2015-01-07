<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */
use TEDxZurich\Theme\Widget\SpeakersWidget;
use TEDxZurich\Theme\Speakers;

/**
 * @var SpeakersWidget $widget
 */
$instanceParameters = $widget->getInstanceParameters();
$widgetArguments = $widget->getWidgetArguments();

$edition = $instanceParameters['edition'];
$number = $instanceParameters['number'];

/**
 * @var Speakers $speakerService
 */
$speakerService = $widget->getContainer()['speakers'];

echo $widgetArguments['before_widget'];

?><h3 class="widget-title col-xs-12"><?php
echo $instanceParameters['title'];
?></h3><?php

$query = $speakerService->getSpeakersQuery($edition, $number);
while ($query->have_posts()):
    $query->the_post();

    echo $widget->renderTemplate('templates/content/speaker', 'widget');
endwhile;
wp_reset_postdata();

if ($instanceParameters['archive']):
    ?>
    <footer class="col-xs-12">
        <a href="<?php printf('%s/edition/%s', get_post_type_archive_link('speaker'), $edition); ?>"
           title="Speaker archive">View all speakers of <?php echo $edition; ?></a>
    </footer>
<?php
endif;

echo $widgetArguments['after_widget'];


