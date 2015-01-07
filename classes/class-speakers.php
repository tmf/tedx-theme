<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 */

namespace TEDxZurich\Theme;

use Tmf\Wordpress\Container\HookableService;

use WP_Post,
    WP_Query;

/**
 * Class Speakers
 *
 * @package TEDxZurich\Theme
 */
class Speakers extends HookableService
{
    /**
     *
     */
    public function initialize()
    {
        register_post_type('speaker', [
            'public'      => true,
            'label'       => 'Speakers',
            'labels'      => [
                'name'          => 'Speakers',
                'singular_name' => 'Speaker',
            ],
            'description' => 'A speaker represents the person giving a talk',
            'supports'    => ['title', 'author', 'excerpt', 'editor', 'thumbnail', 'revisions'],
            'taxonomies'  => ['edition'],
            'has_archive' => true,
        ]);

        /** @var Posts $postsService */
        $postsService = $this->getContainer()['posts'];
        $postsService->addThumbnailSupport('speaker');

        add_action('save_post_speaker', function ($postId) {
            wp_cache_delete('speakers_with_thumbnails');
        });

        add_filter('pre_get_posts', [$this, 'prepareArchiveQuery']);
        add_shortcode('speakers', [$this, 'speakersShortcode']);
    }

    /**
     * @param WP_Query $query
     */
    public function prepareArchiveQuery(WP_Query $query)
    {
        if ($query->is_main_query() && is_post_type_archive('speaker') && get_query_var('edition')) {
            $query->set('posts_per_page', -1);
        } elseif ($query->is_main_query() && is_post_type_archive('speaker')) {
            $query->set('posts_per_page', 20);
        }
    }

    /**
     * @param string $edition
     * @param int    $numberOfSpeakers
     * @param bool   $excludeCurrent
     * @return WP_Query
     */
    public function getSpeakersQuery($edition, $numberOfSpeakers = 4, $excludeCurrent = true)
    {
        $queryArguments = [
            'post_type'      => 'speaker',
            'posts_per_page' => intval($numberOfSpeakers),
            'orderby'        => 'rand',
            'tax_query'      => [
                [
                    'taxonomy' => 'edition',
                    'field'    => 'slug',
                    'terms'    => $edition
                ]
            ],
            'meta_query'     => [
                [
                    'key'     => '_thumbnail_id',
                    'compare' => 'EXISTS'
                ]
            ]
        ];

        if (intval($numberOfSpeakers) < 0) {
            $queryArguments['orderby'] = 'name';
        }
        if ($excludeCurrent) {
            $queryArguments['post__not_in'] = [get_the_ID()];
        }

        return new WP_Query($queryArguments);
    }

    /**
     * @param $attributes
     * @return string
     */
    public function speakersShortcode($attributes)
    {
        $attributes = shortcode_atts([
            'year' => 0
        ], $attributes);

        if (intval($attributes['year']) == 0) {
            $attributes['year'] = $this->getContainer()['editions']->getLatestEditionTermSlug();
        }

        /** @var \Tmf\Wordpress\Service\SimpleTemplating $templatingService */
        $templatingService = $this->getContainer()['templating'];

        return $templatingService->renderTemplatePart('templates/content/speakers', 'shortcode', [
            'speakersQuery' => $this->getSpeakersQuery($attributes['year'], -1, false)
        ]);
    }

    /**
     * @return array
     */
    public function getSpeakersWithThumbnails()
    {
        $speakersWithThumbnails = wp_cache_get('speakers_with_thumbnails');
        if ($speakersWithThumbnails === false) {
            $talks = get_posts(['post_type' => 'speaker', 'posts_per_page' => -1]);

            $speakersWithThumbnails = array_map(function (WP_Post $speaker) {
                list($thumbnail) = wp_get_attachment_image_src(get_post_thumbnail_id($speaker->ID));
                $speaker->post_thumbnail = json_decode(json_encode(['thumbnail' => $thumbnail]));
                $speaker->post_author_nicename = get_the_author_meta('display_name', $speaker->post_author);

                return $speaker;
            }, $talks);
            wp_cache_set('speakers_with_thumbnails', $speakersWithThumbnails);
        }

        return $speakersWithThumbnails;
    }

    /**
     * @return array
     */
    public function getSpeakerDropdownItems()
    {
        return array_map(function (WP_Post $speaker) {
            return [
                'label' => $speaker->post_title,
                'value' => $speaker->ID,
                'data'  => ['data' => htmlentities(json_encode($speaker))]
            ];
        }, $this->getSpeakersWithThumbnails());
    }
} 