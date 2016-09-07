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

    /**
     * @param $file
     * @param string $dir
     * @return array|mixed|object
     */
    public function getConfig($file, $dir ='')
    {

        if($dir !=''){
            $file = get_template_directory() . '/config/' . $dir .'/' . $file . '.json';
        }
        else{
            $file = get_template_directory() . '/config/'  . $file . '.json';
        }
        if (file_exists($file)) {
            $this->config = json_decode(file_get_contents($file), true);
        }
        else{
            $this->config = array();
        }
        return $this->config;
    }

    public function __construct()
    {
        $this->registerPostType();
        $this->registerTaxType();
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
     * Register custom tax
     */
    private function registerTaxType()
    {
        $tax = $this->getConfig('tax');

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
        $posts = $this->getConfig('posts');
        foreach ($posts as $key => $item) {
            $item['args']['labels'] = $item['labels'];
            $this->register_post_type($key, $item['args']);
        }
    }

}