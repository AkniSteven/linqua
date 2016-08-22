<?php

/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 22.08.16
 * Time: 22:46
 */
namespace ilinqua\app\Model;

use ilinqua\app\core\Config;

class Construct
{
    /**
     * @var Config load configurations method
     */
    private $config;

    public function __construct()
    {
        $this->config = new Config();
        $this->registerWidgets();
        $this->registerMenus();
        $this->registerPostType();
        $this->registerTaxType();
        $this->supportInstall();
        $this->addImageSize();
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * This method need for use $this,
     * for default php functions.
     */
    public function __call($name, $arguments)
    {
        if (function_exists($name)) {
            return call_user_func_array($name, $arguments);
        }
        return false;
    }

    /**
     * Add thumbnails to theme.
     */
    private function supportInstall(){
        $this->add_theme_support('post-thumbnails');
    }

    /**
     * Register widgets zone.
     */
    private function registerWidgets(){
        $widgets = $this->config->getConfig('widgets_config','style_config');
        foreach ($widgets as $widget) {
            $this->register_sidebar($widget);
        }
    }

    /**
     * Register menu zones
     */
    private function registerMenus(){
        $this->register_nav_menus(
            $this->config->getConfig('menu')
        );
    }

    /**
     * Register custom tax
     */
    private function registerTaxType()
    {
        $tax = $this->config->getConfig('tax');

        foreach ($tax as $key => $item) {
            $item['args']['labels'] = $item['labels'];
            register_taxonomy($key, $item['post_type'], $item['args']);
        }

    }

    /**
     * Register custom post types
     */
    private function registerPostType()
    {
        $posts = $this->config->getConfig('posts');
        foreach ($posts as $key => $item) {
            $item['args']['labels'] = $item['labels'];
            $this->register_post_type($key, $item['args']);
        }
    }

    /**
     * Add image sizes
     */
    private function addImageSize(){
        $images_size = $this->config->getConfig('images_size','style_config');
        foreach($images_size as $size){
            add_image_size($size);
        }
    }

}