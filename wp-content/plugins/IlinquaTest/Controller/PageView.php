<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 18.10.16
 * Time: 23:46
 */

namespace IlinquaTest\Controller;

use Twig_Loader_Filesystem;
use Twig_Environment;

class PageView
{
    /**
     * @var Twig_Loader_Filesystem
     * Must be twig loader object
     */
    protected $_loader;

    /**
     * @var Twig_Environment
     * Must be twig environment object
     */
    protected $_twig;

    /**
     * @var $_renderer
     * use this for make something with rendered template
     */
    protected $_renderer;

    /**
     * PageView constructor.
     * use this for create objects for view models.
     */
    public function __construct()
    {
        $this->_loader = new Twig_Loader_Filesystem(
            TEMPLATE_PATH_TEST . '/views/templates/'
        );
        $this->_twig = new Twig_Environment($this->_loader);
    }

    /**
     * @param $template
     * @param array $options
     * render data for further processing
     */
    public function render($template, array $options)
    {
        $this->_renderer = $this->_twig->render(
            $template, $options
        );
    }

    /**
     * @param string $template
     * @param array $options
     * show rendered data on frontend
     */
    public function display($template='', array $options=[])
    {
        if ($template !=''&& $options) {
            $this->render($template, $options);
        }
        echo  $this->_renderer;
    }
}