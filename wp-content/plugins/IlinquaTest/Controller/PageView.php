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
    protected $_loader;

    protected $_twig;

    protected $_renderer;

    public function __construct()
    {
        $this->_loader = new Twig_Loader_Filesystem(
            TEMPLATE_PATH_TEST . '/views/templates/'
        );
        $this->_twig = new Twig_Environment($this->_loader);
    }


    public function render($template, array $options)
    {
        $this->_renderer = $this->_twig->render(
            $template, $options
        );
    }

    public function display($template='', array $options=[])
    {
        if ($template !=''&& $options) {
            $this->render($template, $options);
        }

        echo  $this->_renderer;
    }
}