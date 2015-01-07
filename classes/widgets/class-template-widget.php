<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

namespace TEDxZurich\Theme\Widget;

use Tmf\Wordpress\Container\ContainerAwareTrait,
    Tmf\Wordpress\Container\ContainerAwareInterface;

use WP_Widget;

/**
 * Class TemplateWidget
 *
 * @package TEDxZurich\Theme\Widget
 */
class TemplatedWidget extends WP_Widget implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var array
     */
    protected $widgetArguments    = [];

    /**
     * @var array
     */
    protected $instanceParameters = [];

    /**
     * @var string
     */
    protected $template = '';

    /**
     * @param array $widgetArguments
     * @param array $instanceParameters
     */
    public function widget($widgetArguments, $instanceParameters)
    {
        $this->setWidgetArguments($widgetArguments);
        $this->setInstanceParameters($instanceParameters);

        echo $this->renderTemplate($this->getTemplate());
    }

    /**
     * @param array $instanceParameters
     * @return string
     */
    public function form($instanceParameters)
    {
        $this->setInstanceParameters($instanceParameters);

        echo $this->renderTemplate($this->getTemplate(), 'form');
    }

    /**
     * @param string $templatePart
     * @param string $specializedTemplatePart
     * @return string template html
     */
    public  function renderTemplate($templatePart, $specializedTemplatePart = '')
    {
        ob_start();
        set_query_var('widget', $this);
        get_template_part($templatePart, $specializedTemplatePart);
        set_query_var('widget', null);

        return ob_get_clean();
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getInstanceParameters()
    {
        return $this->instanceParameters;
    }

    /**
     * @param array $instanceParameters
     */
    public function setInstanceParameters($instanceParameters)
    {
        $this->instanceParameters = $instanceParameters;
    }

    /**
     * @return array
     */
    public function getWidgetArguments()
    {
        return $this->widgetArguments;
    }

    /**
     * @param array $widgetArguments
     */
    public function setWidgetArguments($widgetArguments)
    {
        $this->widgetArguments = $widgetArguments;
    }
} 