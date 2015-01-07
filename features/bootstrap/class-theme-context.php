<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 */

use Behat\Behat\Context\Context,
    Behat\Behat\Context\SnippetAcceptingContext,
    Behat\Gherkin\Node\TableNode;

use Tmf\WordPressExtension\Context\WordPressContext;

/**
 * Defines application features from the specific context.
 */
class ThemeContext extends WordPressContext implements Context, SnippetAcceptingContext
{
    protected $knownWpPostFields = [
        'ID', 'post_content', 'post_name', 'post_title',
        'post_status', 'post_type', 'post_author', 'ping_status',
        'post_parent', 'menu_order', 'to_ping', 'pinged',
        'post_password', 'guid', 'post_content_filtered', 'post_excerpt',
        'post_date', 'post_date_gmt', 'comment_status', 'post_category',
        'tags_input', 'tax_input', 'page_template',
    ];

    /**
     * Add these posts to this wordpress installation
     *
     * @param TableNode $table
     * @param string    $type
     * @see   wp_insert_post
     *
     * @Given /there are ([\w]+) posts$/
     */
    public function thereArePostsOfType($type, TableNode $table)
    {
        $allowedPostKeys = array_flip($this->knownWpPostFields);

        // make sure wordpress can understand post types
        if (!in_array($type, get_post_types())) {
            register_post_type($type);
        }

        foreach ($table->getHash() as $row) {
            $postData = array_intersect_key($row, $allowedPostKeys);
            $metaData = array_diff_key($row, $allowedPostKeys);

            $postData['post_type'] = $type;

            // make sure wordpress can understand taxonomies
            if (isset($postData['tax_input'])) {
                foreach (array_unique(array_keys($postData['tax_input'])) as $taxonomy) {
                    register_taxonomy($taxonomy, $type);
                }

            }

            $postId = wp_insert_post($postData);
            if (!is_int($postId)) {
                throw new \InvalidArgumentException("Invalid post information schema.");
            }
            foreach ($metaData as $key => $cellValue) {
                $values = array_filter(array_map('trim', explode(',', $cellValue)));
                foreach ($values as $value) {
                    $post = get_page_by_title($value, OBJECT, get_post_types());
                    if (isset($post->ID)) {
                        $value = $post->ID;
                    }
                    add_post_meta($postId, $key, $value);
                }
            }
        }
    }

    /**
     * Add these posts to this wordpress installation
     *
     * @param string $stylesheet
     * @see   wp_insert_post
     *
     * @Given the :stylesheet theme is installed
     */
    public function themeIsActive($stylesheet)
    {
        switch_theme($stylesheet);
    }
}
