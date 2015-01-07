<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 */

namespace TEDxZurich\Theme;

use Tmf\Wordpress\Container\HookableService;

/**
 * Class Menus
 *
 * @package TEDxZurich\Theme\Service
 */
class Menus extends HookableService
{
    /**
     *
     */
    public function initialize()
    {
        register_nav_menu('primary', 'Main navigation');
        register_nav_menu('top', 'Top navigation');

        /** @var Assets $assets */
        $assets = $this->getContainer()['assets'];

        add_theme_support('custom-header', [
            'flex-width'    => true,
            'width'         => 502,
            'flex-height'   => true,
            'height'        => 113,
            'default-image' => $assets->resolveUri('resources/images/logo.png'),
            'uploads'       => true,
        ]);
        add_filter('nav_menu_css_class', [$this, 'filterNavMenuCssClass'], 10, 3);

        add_action('wp_update_nav_menu', [$this, 'invalidateTransient']);
    }

    /**
     * @param array $classes css classes array
     * @param object $item the menu item
     * @param array $args menu arguments
     * @return array new css classes
     */
    public function filterNavMenuCssClass($classes, $item, $args)
    {
        if (isset($args->top_level_item_classes) && intval($item->menu_item_parent) == 0) {
            $classes = array_merge($classes, explode(' ', $args->top_level_item_classes));
        }
        if (isset($args->item_classes)) {
            $classes = array_merge($classes, explode(' ', $args->item_classes));
        }

        return $classes;
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function get($options = [])
    {
        $requestUriHash = md5($_SERVER['REQUEST_URI']);
        $menuHash = 'menu_' . $options['theme_location'] . $requestUriHash;
        $menu = get_transient($menuHash);
        if ($menu === false) {
            $options['echo'] = false;
            $menu = wp_nav_menu($options);

            set_transient($menuHash, $menu);
            $hashes = get_transient('menu_' . $options['theme_location'] . '_hashes');
            if (!is_array($hashes)) {
                $hashes = [];
            }
            $hashes[] = $menuHash;
            set_transient('menu_' . $options['theme_location'] . '_hashes', $hashes);
        }

        return $menu;
    }

    /**
     * @param $id
     */
    public function invalidateTransient($id)
    {
        $locationsById = array_flip(get_nav_menu_locations());
        $hashes = get_transient('menu_' . $locationsById[$id] . '_hashes');
        if (is_array($hashes)) {
            foreach ($hashes as $hash) {
                delete_transient($hash);
            }
        }
        delete_transient('menu_' . $locationsById[$id] . '_hashes');
    }
}