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
    
}