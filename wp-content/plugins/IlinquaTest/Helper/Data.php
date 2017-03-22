<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 14.10.16
 * Time: 22:28
 */

namespace IlinquaTest\Helper;

class Data
{
    /**
     * @param $string
     * @param string $allow
     * @return string
     * Function for clear text from text
     */
    public static function cleanString($string, $allow='')
    {
        return trim(strip_tags($string, $allow));
    }

    /**
     * @param $file
     * @param string $dir
     * @return array|mixed|object
     */
    public static function getConfig($file, $dir ='')
    {
        if ($dir !='') {
            $file = TEMPLATE_PATH_TEST . $dir .'/' . $file . '.json';
        } else {
            $file = TEMPLATE_PATH_TEST . '/config/'  . $file . '.json';
        }
        if (file_exists($file)) {
            $config = json_decode(file_get_contents($file), true);
        } else {
            $config = array();
        }
        return $config;
    }
    
}