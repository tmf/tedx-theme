<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2015 Tom Forrer (http://github.com/tmf)
 */

namespace TEDxZurich\Theme;

use WP_Query;
use Tmf\Wordpress\Container\HookableService,
    Tmf\Wordpress\Service\Metabox\Metabox,
    Tmf\Wordpress\Service\Metabox\Item\DropdownItem,
    Tmf\Wordpress\Service\Metabox\Item\TextareaItem;

/**
 * Class FrontPage
 *
 * @package TEDxZurich\Theme
 */
class FrontPage extends HookableService
{
    /**
     *
     */
    public function initialize()
    {
        add_action('admin_init', [$this, 'registerMetabox']);
    }

    /**
     *
     */
    public function registerMetabox()
    {
        $services = $this->getContainer();
        if ($services['templating']->isPageTemplate('templates/page-templates/frontpage.php', $this->guessCurrentPostId())) {

            $services['metaboxes']['front_page'] = new Metabox('Frontpage settings', ['page'], 'normal', 'high');
            $services['metaboxes']['front_page']['slider_category'] = new DropdownItem([
                'multiple' => false,
                'label' => 'Display posts from the following category in the slider',
                'options' => $this->getCategoryOptions()
            ]);
            $services['metaboxes']['front_page']['live_stream_iframe'] = new TextareaItem(['label' => 'Slider Replacement HTML', 'description' => 'Put your <iframe> HTML code here to display it instead of the slider']);
        }
    }

    /**
     * @return WP_Query
     */
    public function getFeaturedPostsQuery(){
        return new WP_Query([
            'number_of_posts' => -1,
            'post_type'       => 'any',
            'tax_query'       => [
                [
                    'taxonomy' => 'category',
                    'terms'    => intval(get_post_meta(get_the_ID(), 'slider_category', true))
                ]
            ],
            'meta_query'      => [
                [
                    'key'     => '_thumbnail_id',
                    'compare' => 'EXISTS'
                ]
            ]
        ]);
    }

    /**
     * @return string
     */
    public function getIFrameContents(){
        return trim(get_post_meta(get_the_ID(), 'live_stream_iframe', true));
    }

    /**
     * @return array
     */
    protected function getCategoryOptions(){
        return array_map(function($term){
            return ['label' => $term->name, 'value' => $term->term_id];
        }, get_terms('category'));
    }

    /**
     * Helper function to guess the current post id, for the case when objects like WP_Screen WP_Query are not yet set
     * up
     */
    public function guessCurrentPostId()
    {
        $postId = 0;

        // if the post is somehow set up internally with some globals
        $post = get_post();
        if (isset($post->ID)) {
            $postId = $post->ID;
        } else if (isset($_POST['post_ID'])) {
            // passed in a backend form submission
            $postId = absint($_POST['post_ID']);
        } else if (isset($_GET['post'])) {
            // passed in a direct backend request
            $postId = absint($_GET['post']);
        } else if (isset($_GET['revision'])) {
            // passed in the revision screen
            $revisionId = absint($_GET['revision']);
            $revision = get_post($revisionId);
            $postId = $revision->post_parent;
        }

        return $postId;
    }

}