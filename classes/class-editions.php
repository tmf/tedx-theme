<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

namespace TEDxZurich\Theme;

use Tmf\Wordpress\Container\HookableService;
use WP_Rewrite;

/**
 * Class Editions
 *
 * @package TEDxZurich\Theme
 */
class Editions extends HookableService
{
    public function initialize()
    {
        register_taxonomy('edition', ['talk', 'speaker'], [
            'label'             => 'Editions',
            'labels'            => [
                'singular_name' => 'Edition',
                'all_items'     => 'All editions',
                'edit_item'     => 'Edit edition',
                'add_new_item'  => 'Add new edition',
                'new_item_name' => 'New edition name',
                'parent_item'   => 'Parent edition',
            ],
            'show_admin_column' => true,
            'show_tagcloud'     => false,
            'hierarchical'      => true
        ]);
        add_action('restrict_manage_posts', [$this, 'restrictByEdition']);
        add_action('generate_rewrite_rules', [$this, 'generateRewriteRules']);
    }

    /**
     * @param WP_Rewrite $rewrite
     */
    public function generateRewriteRules(WP_Rewrite $rewrite)
    {
        $edition = get_taxonomy('edition');

        $editionRules = array_combine(
            array_map(function ($postType) use ($rewrite) {
                return sprintf('%s/edition/(.+)', $postType);
            }, $edition->object_type),
            array_map(function ($postType) use ($rewrite) {
                return sprintf('index.php?post_type=%s&edition=%s', $postType, $rewrite->preg_index(1));
            }, $edition->object_type));

        $rewrite->rules = $editionRules + $rewrite->rules;

    }

    /**
     *
     */
    public function restrictByEdition()
    {
        $screen = get_current_screen();
        if (is_object_in_taxonomy($screen->post_type, 'edition')) {
            $currentEditionSlug = get_query_var('edition');
            echo $this->getEditionsDropdown($currentEditionSlug, true);
        }
    }

    /**
     * @param        $currentEdition
     * @param bool   $showEmptyOption
     * @param string $fieldName
     * @return string
     */
    public function getEditionsDropdown($currentEdition, $showEmptyOption = false, $fieldName = 'edition')
    {
        $editions = get_terms('edition', ['hide_empty' => false]);
        $emptyOption = '';
        if ($showEmptyOption) {
            $emptyOption = '<option value="">View all editions</option>';
        }

        return sprintf(
            '<select name="%s">%s</select>',
            $fieldName,
            array_reduce($editions, function ($html, $edition) use ($currentEdition) {
                return $html . sprintf(
                    '<option value="%s" %s>%s</option>',
                    $edition->slug, selected($edition->slug, $currentEdition, false), $edition->name
                );
            }, $emptyOption)
        );
    }

    /**
     * @return string
     */
    public function getLatestEditionTermSlug()
    {
        $editions = get_terms('edition');
        $latestEditionTerm = array_pop($editions);
        if (isset($latestEditionTerm->slug)) {
            return $latestEditionTerm->slug;
        }

        return '';
    }
}