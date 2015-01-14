<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 */

namespace TEDxZurich\Theme;

use Tmf\Wordpress\Container\HookableService,
    Tmf\Wordpress\Service\Metabox\Metabox,
    Tmf\Wordpress\Service\Metabox\Item\PostsDropdownItem;
use WP_Post;
use WP_Query;

/**
 * Class Speakers
 *
 * @package TEDxZurich\Theme
 */
class Talks extends HookableService
{
    /**
     * register the 'talk' post type, hook up the shortcode and the metabox
     */
    public function initialize()
    {
        register_post_type('talk', [
            'public'      => true,
            'label'       => 'Talks',
            'labels'      => [
                'name'          => 'Talks',
                'singular_name' => 'Talks',
            ],
            'description' => 'A talk is given by a speaker',
            'supports'    => ['title', 'author', 'excerpt', 'editor', 'thumbnail', 'revisions'],
            'taxonomies'  => ['edition'],
            'has_archive' => true,
        ]);


        /** @var Posts $postsService */
        $postsService = $this->getContainer()['posts'];
        $postsService->addThumbnailSupport('talk');

        add_action('save_post_talk', function ($postId) {
            wp_cache_delete('talks_with_thumbnails');
        });

        add_shortcode('talks', [$this, 'talksShortcode']);
        add_action('admin_init', [$this, 'registerMetabox']);
    }

    /**
     * register a metabox for the 'talk' post type providing a connection to the associated speaker with a dropdown item
     */
    public function registerMetabox()
    {
        $services = $this->getContainer();
        $services['metaboxes']['speakers_by_talks'] = new Metabox('Speakers', ['talk'], 'normal', 'high');
        $services['metaboxes']['speakers_by_talks']['_talk_speaker'] = new PostsDropdownItem(['options' => [$services['speakers'], 'getSpeakerDropdownItems']]);
    }

    /**
     * Get all 'talk' posts and inject the post thumbnail and the post author
     * The results are cached (and invalidated through the 'save_post_talk' action)
     *
     * @return array
     */
    public function getTalksWithThumbnails()
    {
        $talksWithThumbnails = wp_cache_get('talks_with_thumbnails');
        if ($talksWithThumbnails === false) {
            $talks = get_posts(['post_type' => 'talk', 'posts_per_page' => -1]);

            $talksWithThumbnails = array_map(function (WP_Post $talk) {
                list($thumbnail) = wp_get_attachment_image_src(get_post_thumbnail_id($talk->ID));
                $talk->post_thumbnail = json_decode(json_encode(['thumbnail' => $thumbnail]));
                $talk->post_author_nicename = get_the_author_meta('display_name', $talk->post_author);

                return $talk;
            }, $talks);
            wp_cache_set('talks_with_thumbnails', $talksWithThumbnails);
        }

        return $talksWithThumbnails;
    }

    /**
     * Callback for the PostsDropdownItem metabox item: generate a structured output from available 'talk' posts (only with thumbnails).
     *
     * @return array
     */
    public function getTalkDropdownItems()
    {
        return array_map(function (WP_Post $talk) {
            return [
                'label' => $talk->post_title,
                'value' => $talk->ID,
                'data'  => ['data' => htmlentities(json_encode($talk))]
            ];
        }, $this->getTalksWithThumbnails());
    }

    /**
     * 'talks' shortcode callback: render 'talk' posts associated with a specific 'edition' term
     *
     * @param array $attributes shortcode attributes
     * @return string
     */
    public function talksShortcode($attributes)
    {
        $attributes = shortcode_atts([
            'year' => 0,
            'max' => 8
        ], $attributes);

        if (intval($attributes['year']) == 0) {
            $attributes['year'] = $this->getContainer()['editions']->getLatestEditionTermSlug();
        }

        /** @var \Tmf\Wordpress\Service\SimpleTemplating $templatingService */
        $templatingService = $this->getContainer()['templating'];

        return $templatingService->renderTemplatePart('templates/content/talks', 'shortcode', [
            'talksQuery' => $this->getTalksQuery($attributes['year'], $attributes['max'])
        ]);

    }

    /**
     * Get a WP_Query which queries 'talk' posts associated with a specific 'edition' term
     *
     * @param string $edition the term slug from the edition taxonomy
     * @param int $max the maximum number of talks
     * @return WP_Query
     */
    public function getTalksQuery($edition, $max = -1)
    {
        return new WP_Query([
            'post_type'       => 'talk',
            'posts_per_page' => $max,
            'orderby' => 'rand',
            'tax_query'       => [
                [
                    'taxonomy' => 'edition',
                    'field'    => 'slug',
                    'terms'    => [$edition]
                ]
            ]
        ]);
    }
} 