<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 */

?><!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes()?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes()?>> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes() ?>> <!--<![endif]-->

<head>
    <title><?php wp_title(); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?php echo $services['assets']->resolveUri('resources/images/favicon.ico'); ?>" />

    <?php wp_head(); ?>
    <!--[if lt IE 9]>
        <?php wp_print_scripts(['html5shiv', 'respond.js', 'selectivizr']); ?>
    <![endif]-->
</head>
<body <?php body_class(); ?>>

<div class="container-fluid">
    <div class="row-offcanvas row-offcanvas-left">
    <header role="banner" class="clearfix">

        <?php get_template_part('templates/partials/sidebar', 'top'); ?>

        <nav role="navigation" class="clearfix">
            <div class="col-md-4">
                <div class="menu-item menu-item-box full-menu-height">
                    <a class="home" href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo('name') ?>">
                        <div class="visible-xs visible-sm" data-toggle="offcanvas">
                            <i class="icon icon__hamburger"></i>
                            <span>Navigation</span>
                        </div>

                        <h1 class="sr-only"><?php echo get_bloginfo('name') ?></h1>

                        <h2 class="sr-only"><?php echo get_bloginfo('description') ?></h2>
                        <img class="logo" src="<?php header_image(); ?>" alt="logo"/>
                    </a>

                </div>
            </div>
            <div class="sidebar-offcanvas">
                <div class="col-md-6">
                    <ul class="list-style-none menu main-menu row">
                        <li class="menu-item visible-xs visible-sm">
                            <div data-toggle="offcanvas">
                                <i class="icon icon__close"></i>
                            </div>
                        </li>
                        <?php echo $services['menus']->get([
                            'theme_location'         => 'primary',
                            'container'              => false,
                            'items_wrap'             => '%3$s',
                            'link_before'            => '<span>',
                            'link_after'             => '</span>',
                            'top_level_item_classes' => 'col-md-4 menu-item-box half-menu-height'
                        ]); ?>
                    </ul>
                </div>
                <div class="col-md-2">
                    <ul class="list-style-none menu top-menu row">
                        <?php echo $services['menus']->get([
                            'theme_location'         => 'top',
                            'container'              => false,
                            'items_wrap'             => '%3$s',
                            'link_before'            => '<span>',
                            'link_after'             => '</span>',
                            'top_level_item_classes' => 'col-md-12 menu-item-box quarter-menu-height'
                        ]); ?>
                    </ul>
                </div>
                <div class="inset-shadow" data-toggle="offcanvas"></div>
            </div>
        </nav>

        <?php get_template_part('templates/partials/sidebar', 'teaser'); ?>
    </header>

    <section role="main" class="col-md-12">
        <div class="box clearfix">
            <div class="row">