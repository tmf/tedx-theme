<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

namespace TEDxZurich\Theme;

use Tmf\Wordpress\Container\HookableService;
use WP_Query,
    WP_Rewrite;

/**
 * Class Posts
 *
 * @package TEDxZurich\Theme
 */
class Posts extends HookableService
{
    /**
     *
     */
    public function initialize()
    {
        $this->addThumbnailSupport('post');

        add_shortcode('sitecontent', [$this, 'sitecontentShortcode']);
        add_action('generate_rewrite_rules', [$this, 'generateSearchRewriteRules']);
    }

    /**
     * @param WP_Rewrite $rewrite
     */
    public function generateSearchRewriteRules(WP_Rewrite $rewrite)
    {
        $rewrite->rules = ['search/(.+)' => 'index.php?s=' . $rewrite->preg_index(1)] + $rewrite->rules;
    }

    /**
     * @param $postType
     */
    public function addThumbnailSupport($postType)
    {
        $thumbnailsThemeSupport = get_theme_support('post-thumbnails') ? get_theme_support('post-thumbnails')[0] : [];
        $thumbnailsThemeSupport[] = $postType;
        add_theme_support('post-thumbnails', $thumbnailsThemeSupport);

        add_filter(sprintf('manage_%s_posts_columns', $postType), [$this, 'addThumbnailColumn']);
        add_action(sprintf('manage_%s_posts_custom_column', $postType), [$this, 'displayThumbnailColumn'], 10, 2);
    }

    /**
     * @param $columns
     * @return mixed
     */
    public function addThumbnailColumn($columns)
    {
        $columns['thumbnail'] = 'Featured image';

        return $columns;
    }

    /**
     * @param $column
     * @param $postId
     */
    public function displayThumbnailColumn($column, $postId)
    {
        if ($column == 'thumbnail') {
            the_post_thumbnail('thumbnail');
        }
    }

    /**
     * @param $attributes
     * @return string
     */
    public function sitecontentShortcode($attributes)
    {
        $attributes = shortcode_atts([
            'id' => 0
        ], $attributes);

        $query = new WP_Query([
            'post_type'       => 'any',
            'number_of_posts' => -1,
            'post__in'        => [
                $attributes['id']
            ]
        ]);
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('templates/content/post', 'content');
        }
        wp_reset_query();

        return ob_get_clean();
    }
}