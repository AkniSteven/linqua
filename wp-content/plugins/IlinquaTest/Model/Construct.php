<?php

/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 22.08.16
 * Time: 22:46
 */
namespace IlinquaTest\Model;


class Construct
{
    public $config;
    
    public function __construct()
    {
        add_action('init', array($this, 'registerTaxType'));
        add_action('init', array($this, 'registerPostType'));

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
     * @param $file
     * @param string $dir
     * @return array|mixed|object
     */
    public function getConfig($file, $dir ='')
    {

        if ($dir !='') {
            $file = TEMPLATE_PATH_TEST . $dir .'/' . $file . '.json';
        } else {
            $file = TEMPLATE_PATH_TEST . '/config/'  . $file . '.json';
        }
        if (file_exists($file)) {
            $this->config = json_decode(file_get_contents($file), true);
        } else {
            $this->config = array();
        }
        return $this->config;
    }

    /**
     * Register custom tax
     */
    public function registerTaxType()
    {
        $tax = $this->getConfig('tax');

        foreach ($tax as $key => $item) {
            $item['args']['labels'] = $item['labels'];
            $this->register_taxonomy($key, $item['post_type'], $item['args']);
        }

    }

    /**
     * Register custom post types
     */
    public function registerPostType()
    {
        $posts = $this->getConfig('posts');
        foreach ($posts as $key => $item) {
            $item['args']['labels'] = $item['labels'];
            $this->register_post_type($key, $item['args']);
        }
    }
}