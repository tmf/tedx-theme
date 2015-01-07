<?php
/**
 * @autor Tom Forrer <tom.forrer@gmail.com>
 */

namespace TEDxZurich\Theme\Widget;

/**
 * Class Teaser
 *
 * @package TEDxZurich\Theme\Widget
 */
class TeaserWidget extends TemplatedWidget
{
    /**
     * @var string
     */
    protected $template = 'templates/widgets/teaser';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct('TeaserWidget', 'Teaser Widget', [
            'classname'   => 'TeaserWidget',
            'description' => 'Shows teaser button on front page'
        ]);
    }
} 