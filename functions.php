<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 TEDxZurich (http://www.tedxzurich.com)
 *
 * In a WordPress theme, functions.php is the first entry point.
 * From here, every functionality of the theme is bootstrapped:
 *  - load vendors (see README.md, "Installation" for further details)
 *  - create a service container (with pimple)
 *  - add services (templating, assets, menus, sidebars, speakers, talks)
 *
 * Services are registered to the service container in a way that gets the service instance instantiated
 * at the moment a specified wordpress hook is triggered. Services are only instantiated once (but you
 * could create factory services in a Pimple container).
 *
 * With the "templating" service, the service container is available as "$services", a specific service method
 * available as "$service['myservice']->myMethod()" in all WordPress query templates and all template parts.
 */

// load the composer autoloader (for class map autoloading, and the pimple library)
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// the HookableServiceProvider is a Pimple ServiceProvider which registers TEDxZurich\Theme\Container\HookableService services
use Tmf\Wordpress\Container\HookableServiceProvider,
    Tmf\Wordpress\Service\SimpleTemplatingServiceProvider,
    Tmf\Wordpress\Service\Metabox\MetaboxServiceProvider;

// a pimple container will serve as this theme's service container
$services = new Pimple\Container();


// register the templating service (for templates in the ./templates directory)
$services->register(
    new SimpleTemplatingServiceProvider('templating'),
    array('templating.directory' => 'templates')        // set up the "templates" directory as the "templating.directory" configuration parameter in the service container
);

// register the metabox helper service
$services->register(new MetaboxServiceProvider(), [
    'metaboxes.vendor_directory' => get_stylesheet_directory() . '/vendor',
    'metaboxes.base_directory'   => get_stylesheet_directory() . '/vendor/tmf/wp-metabox-helper'
]);

// register assets service: register theme scripts and styles
$services->register(new HookableServiceProvider('assets', 'TEDxZurich\Theme\Assets', [
    ['hook' => 'wp_enqueue_scripts', 'method' => 'enqueueAssets'],
    ['hook' => 'admin_enqueue_scripts', 'method' => 'enqueueAdminAssets'],
    ['hook' => 'sidebar_admin_setup', 'method' => 'enqueueWidgetAssets']
]));


// register menus service: register theme menu locations (default entry point method: "initialize" on "init" action)
$services->register(new HookableServiceProvider('menus', 'TEDxZurich\Theme\Menus'));


// register sidebars service: register theme sidebars (default entry point method: "initialize" on "init" action)
$services->register(new HookableServiceProvider('sidebars', 'TEDxZurich\Theme\Sidebars'));


// register widgets service: register theme widgets
$services->register(new HookableServiceProvider('widgets', 'TEDxZurich\Theme\Widgets',
    [['hook' => 'widgets_init', 'method' => 'registerWidgets']]
));

$services->register(new HookableServiceProvider('images', 'TEDxZurich\Theme\Images'));

$services->register(new HookableServiceProvider('posts', 'TEDxZurich\Theme\Posts'));

$services->register(new HookableServiceProvider('frontpage', 'TEDxZurich\Theme\FrontPage'));

// register speakers service: register speaker custom post type (default entry point method: "initialize" on "init" action)
$services->register(new HookableServiceProvider('editions', 'TEDxZurich\Theme\Editions'));

// register speakers service: register speaker custom post type (default entry point method: "initialize" on "init" action)
$services->register(new HookableServiceProvider('speakers', 'TEDxZurich\Theme\Speakers'));

// register talks service: register talk custom post type (default entry point method: "initialize" on "init" action)
$services->register(new HookableServiceProvider('talks', 'TEDxZurich\Theme\Talks'));