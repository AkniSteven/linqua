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
use ilinqua\app\Helper\Data;
use Timber\Timber;
class CoreTheme extends Timber
{
    /**
     * @var Config load configurations method
     */
    private $_config;

    /**
     * @var Construct register parts of wp
     */
    private $_construct;
    
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
        add_filter(
            'acf/fields/google_map/api', [$this, 'setMapApiKey']
        );

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
        return $this->_config;
    }
    
    /**
     * Setup all main classes
     */
    public function setUp()
    {
        $this->_config = new Config();
        $this->_construct = new Construct();
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
        #site url
        $data['site_url'] = $this->get_site_url();
        #random number in string format
        $data['rand'] = (string)rand();
        #header menu
        $headerMenuLocation =  get_nav_menu_locations()['primary-header-menu'];
        if ($headerMenuLocation !== null) {
            $data['primary_header_menu'] = wp_get_nav_menu_items(
                $headerMenuLocation
            );
        }
        #theme_options
        $data['theme_options'] = (array) get_option('ice-theme-settings');

        #Home template pages
        $data['home_pages'] = get_pages(
            [
                'meta_key' => '_wp_page_template',
                'meta_value' => 'page-templates/home-page.php'
            ]
        );
        if (!empty($data['home_pages'])) {
            $this->model->setResult($data['home_pages']);
            $this->model->setPostUrls();
            $data['languageList'] = $this->model->getResult();
        }
        return $data;
    }

    /**
     * This formate date
     * @param $date
     * @return string
     */
    public function specialDateFormat($date)
    {
        $d = date('d',strtotime($date));
        $m = date('m',strtotime($date));
        $y = date('Y',strtotime($date));
        $month = __($this->_config->getConfig(
            "date",
            "style_config"
        )
        ['months'][$m]);
        $formated_date = $d . ' ' .  mb_strtolower($month,'UTF-8') . ' ' . $y;
        return $formated_date;
    }
    /**
     * @param $api
     * @return mixed
     * this set google map api
     */
    public function setMapApiKey($api)
    {
        $api['key'] = 'AIzaSyDlz7f8qQwqDy9wl8IRIZ58NiYgXTrqBTk';
        return $api;
    }

}