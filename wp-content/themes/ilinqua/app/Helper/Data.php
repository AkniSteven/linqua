<?php

/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 22.08.16
 * Time: 22:56
 */

namespace ilinqua\app\Helper;

class Data
{
    /**
     * @param $string
     * @param string $allow
     * @return string
     * Function for clear text from text
     */
    public static function cleanString($string, $allow=''){
        return trim(strip_tags($string,$allow));
    }

    /**
     * @param $attachment_id
     * @return mixed
     * Return attachment images
     */
    public static function getAttachmentMeta($attachment_id){
        $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
        if($alt == ''){
            $alt = explode('.', basename(get_attached_file($attachment_id)))[0];
        }
        return $alt;
    }
}