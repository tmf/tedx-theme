<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 */

namespace TEDxZurich\Theme;

use Tmf\Wordpress\Container\HookableService;

/**
 * Class Assets
 *
 * @package TEDxZurich\Theme\Service
 */
class Assets extends HookableService
{
    protected $templateDirectory      = '';
    protected $stylesheetDirectory    = '';
    protected $templateDirectoryUri   = '';
    protected $stylesheetDirectoryUri = '';

    /**
     *
     */
    public function enqueueAssets()
    {
        wp_enqueue_style('tedx-theme', $this->resolveUri('resources/styles/frontend.min.css'));
        wp_enqueue_script('tedx-theme', $this->resolveUri('resources/scripts/frontend.js'), [], false, true);
        wp_register_script('html5shiv', $this->resolveUri('vendor/bower_components/html5shiv/dist/html5shiv.min.js'));
        wp_register_script('respond.js', $this->resolveUri('vendor/bower_components/respond/dest/respond.min.js'));
        wp_register_script('selectivizr', $this->resolveUri('vendor/bower_components/selectivizr/selectivizr.js'));
    }

    /**
     *
     */
    public function enqueueAdminAssets()
    {
        wp_enqueue_style('tedx-theme-backend', $this->resolveUri('resources/styles/backend.min.css'));
        add_editor_style($this->resolveUri('resources/styles/frontend.min.css'));
    }

    /**
     *
     */
    public function enqueueWidgetAssets()
    {
        wp_enqueue_script('tedx-widgets-backend', $this->resolveUri('resources/scripts/backend.js'), ['jquery', 'jquery-ui-sortable']);

        wp_enqueue_script('selectize', $this->resolveUri('vendor/bower_components/selectize/dist/js/standalone/selectize.min.js'), ['jquery']);
        wp_enqueue_style('selectize', $this->resolveUri('vendor/bower_components/selectize/dist/css/selectize.default.css'));
    }

    /**
     * Resolve the path: if the relative $file path exist in the child theme, the child theme absolute path + file is
     * returned, otherwise from the parent (or normal) theme path.
     *
     * @param string $file
     * @return string
     */
    public function resolvePath($file)
    {
        $filePath = '';
        if (file_exists($this->getTemplateDirectory() . '/' . $file)) {
            $filePath = $this->getTemplateDirectory() . '/' . $file;
        }
        if (file_exists($this->getStylesheetDirectory() . '/' . $file)) {
            $filePath = $this->getStylesheetDirectory() . '/' . $file;
        }

        return $filePath;
    }

    /**
     * resolve the uri: if the relative $file path exists in the child theme, the child theme absolute uri + file is
     * returned, otherwise from the parent (or normal) theme path.
     *
     * @param $file
     * @return string
     */
    public function resolveUri($file)
    {
        $filePath = '';
        if (file_exists($this->getTemplateDirectory() . '/' . $file)) {
            $filePath = $this->getTemplateDirectoryUri() . '/' . $file;
        }
        if (file_exists($this->getStylesheetDirectory() . '/' . $file)) {
            $filePath = $this->getStylesheetDirectoryUri() . '/' . $file;
        }

        return $filePath;
    }

    /**
     * @return string
     */
    public function getStylesheetDirectory()
    {
        if (!$this->stylesheetDirectory) {
            $this->stylesheetDirectory = get_stylesheet_directory();
        }

        return $this->stylesheetDirectory;
    }

    /**
     * @return string
     */
    public function getStylesheetDirectoryUri()
    {
        if (!$this->stylesheetDirectoryUri) {
            $this->stylesheetDirectoryUri = get_stylesheet_directory_uri();
        }

        return $this->stylesheetDirectoryUri;
    }

    /**
     * @return string
     */
    public function getTemplateDirectory()
    {
        if (!$this->templateDirectory) {
            $this->templateDirectory = get_template_directory();
        }

        return $this->templateDirectory;
    }

    /**
     * @return string
     */
    public function getTemplateDirectoryUri()
    {
        if (!$this->templateDirectoryUri) {
            $this->templateDirectoryUri = get_template_directory_uri();
        }

        return $this->templateDirectoryUri;
    }

} 