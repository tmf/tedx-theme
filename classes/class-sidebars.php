<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 */

namespace TEDxZurich\Theme;

use Tmf\Wordpress\Container\HookableService;

/**
 * Class Sidebars
 *
 * @package TEDxZurich\Theme\Service
 */
class Sidebars extends HookableService
{
    /**
     *
     */
    public function initialize()
    {
        $defaultSidebarParameters = [
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
            'before_widget' => '<li id="%1$s" class="widget %2$s clearfix">',
            'after_widget'  => '</li>'
        ];
        register_sidebar(array_merge($defaultSidebarParameters, [
            'name'          => 'Sidebar',
            'id'            => 'sidebar-right',
        ]));
        register_sidebar(array_merge($defaultSidebarParameters, [
            'name'          => 'Top',
            'id'            => 'sidebar-top',
        ]));
        register_sidebar(array_merge($defaultSidebarParameters, [
            'name'          => 'Teaser',
            'id'            => 'sidebar-teaser',
            'before_widget' => '<li id="%1$s" class="widget teaser col-md-4 col-md-height col-top %2$s">',
        ]));
        register_sidebar(array_merge($defaultSidebarParameters, [
            'name'          => 'Footer',
            'id'            => 'sidebar-footer',
            'before_widget' => '<li id="%1$s" class="widget col-md-10 col-sm-8 col-xs-6 %2$s">',
        ]));
    }
} 