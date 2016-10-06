<?php

/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 22.08.16
 * Time: 22:29
 */
namespace ilinqua\app\core;

use ilinqua\app\Model\Construct;
use ilinqua\app\Model\Model;
use Timber\Timber;

class CoreTheme extends Timber
{
    /**
     * @var Config load configurations method
     */
    private $config;

    /**
     * @var Construct register parts of wp
     */
    private $construct;
    
    /**
     * @var Model usages
     */
    public $model;

    /**
     * Core constructor.
     */
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'setUp']);
        parent::__construct();
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
     * @return Model
     * Model getter
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return Config
     * Config getter
     */
    public function getConfig()
    {
        return $this->config;
    }
    
    /**
     * Setup all main classes
     */
    public function setUp()
    {
        $this->config = new Config();
        $this->construct = new Construct();
        $this->model = new Model();
        $this->add_filter('timber_context', [$this, 'addToContext']);
    }

    /**
     * @param $data
     * @return mixed
     * return all variables added to context
     */
    public function addToContext($data)
    {
        $data['site_url'] = $this->get_site_url();
        $data['rand'] = (string)rand();
        $data['primary_header_menu'] = '';
        
        return $data;
    }

}