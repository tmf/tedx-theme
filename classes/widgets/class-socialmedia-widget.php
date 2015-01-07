<?php
/**
 * @autor Tom Forrer <tom.forrer@gmail.com>
 */

namespace TEDxZurich\Theme\Widget;

/**
 * Class SocialMedia
 *
 * @package TEDxZurich\Theme\Widget
 */
class SocialMediaWidget extends TemplatedWidget
{
    /**
     * @var string
     */
    protected $template = 'templates/widgets/socialmedia';

    /**
     * @var array $supportedServices
     */
    protected $supportedServices = [
        'facebook', 'twitter', 'flickr', 'newsletter', 'youtube', 'rss', 'pinterest',
        'slideshare', 'vimeo', 'xing', 'linkedin', 'googleplus', 'foursquare'
    ];

    /**
     * @var int
     */
    protected $currentServiceIndex = -1;

    /**
     * WP_Widget constructor
     */
    public function __construct()
    {
        parent::__construct('SocialMediaWidget', 'Social-Media Icons Widget', [
            'classname'   => 'SocialMediaWidget',
            'description' => 'Shows linked social media icons'
        ]);

        add_action('wp_ajax_get_service_template', [$this, 'ajaxRenderServiceTemplate']);
    }

    /**
     *
     */
    public function ajaxRenderServiceTemplate()
    {
        $this->number = intval($_REQUEST['widget_number']);
        echo $this->renderTemplate($this->getTemplate(), 'service-template');
        exit;
    }

    /**
     * @param $service
     * @return string
     */
    public function getServiceDescription($service)
    {
        $name = get_bloginfo();
        switch ($service) {
            case 'newsletter':
                return sprintf('Subscribe to %s\'s newsletter', $name);
                break;
            case 'rss':
                return sprintf('Read %s\'s %s feed', $name, $this->getServiceLabel($service));
                break;
            default:
                return sprintf('Visit %s\'s %s profile', $name, $this->getServiceLabel($service));
        }
    }

    /**
     * @param $service
     * @return string
     */
    public function getServiceLabel($service)
    {
        switch ($service) {
            case 'rss':
                return strtoupper($service);
            case 'googleplus':
                return 'Google+';
                break;
            default:
                return ucfirst($service);
        }
    }

    /**
     * @return array
     */
    public function getSupportedServices()
    {
        return $this->supportedServices;
    }

    /**
     * @return int
     */
    public function getCurrentServiceIndex()
    {
        return $this->currentServiceIndex;
    }

    /**
     * @param int $currentServiceIndex
     */
    public function setCurrentServiceIndex($currentServiceIndex)
    {
        $this->currentServiceIndex = $currentServiceIndex;
    }
}