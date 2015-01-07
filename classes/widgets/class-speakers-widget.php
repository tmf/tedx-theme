<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

namespace TEDxZurich\Theme\Widget;

/**
 * Class SpeakersWidget
 *
 * @package TEDxZurich\Theme\Widget
 */
class SpeakersWidget extends TemplatedWidget
{
    /**
     * @var string
     */
    protected $template = 'templates/widgets/speakers';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct('SpeakersWidget', 'Speakers Widget', [
            'classname'   => 'SpeakersWidget',
            'description' => 'Shows speakers'
        ]);
    }

    /**
     * @param array $newInstance
     * @param array $oldInstance
     * @return array
     */
    public function update($newInstance, $oldInstance){
        if(!isset($newInstance['number']) || intval($newInstance['number'])==0){
            $newInstance['number'] = 4;
        }
        return $newInstance;
    }
}