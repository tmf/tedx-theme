<?php
/**
 * @autor Tom Forrer <tom.forrer@gmail.com>
 */

namespace TEDxZurich\Theme;

use Tmf\Wordpress\Container\ContainerAwareInterface;
use Tmf\Wordpress\Container\HookableService;

/**
 * Class Widgets
 *
 * This service registers custom widgets, like the teaser widget or the socialmedia widget
 *
 * @package TEDxZurich\Theme\Service
 */
class Widgets extends HookableService
{
    /**
     * register all custom widgets and initialize them with the service container
     */
    public function registerWidgets()
    {
        global $wp_widget_factory;
        $widgetClasses = [
            'TEDxZurich\Theme\Widget\TeaserWidget',
            'TEDxZurich\Theme\Widget\SocialMediaWidget',
            'TEDxZurich\Theme\Widget\SpeakersWidget',
        ];

        foreach($widgetClasses as $widgetClass){
            register_widget($widgetClass);

            // after registering the widget (which instantiates it), inject the service container into the widget
            $widgetObject = $wp_widget_factory->widgets[$widgetClass];
            if($widgetObject instanceof ContainerAwareInterface){
                $widgetObject->setContainer($this->getContainer());
            }
        }

        // this theme has a custom search "widget", hardcoded in templates/partials/search-form.php
        unregister_widget('WP_Widget_Search');

        // this theme doesn't support comments, best not to clutter the output
        add_filter('show_recent_comments_widget_style', '__return_false');
    }
} 