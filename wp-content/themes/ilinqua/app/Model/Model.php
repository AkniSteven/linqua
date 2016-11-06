<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 22.08.16
 * Time: 23:15
 */

namespace ilinqua\app\Model;

use Timber\Timber;
use MultiPostThumbnails;

class Model extends Timber
{
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
     * @var $result
     * result of all functions
     */
    private $result;

    /**
     * @var $args
     * params to get result
     */
    private $args;


    /**
     * Return theme options
     * @return array
     */
    private function getThemeOtpions()
    {
        $options = (array) $this->get_option('ice-theme-settings');
        if (is_array($options) && !empty($options)) {
           return $options;
        }
        return [];

    }
    /**
     * @param array $args
     * set main args
     */
    public function setArgs($args=[])
    {
        $this->args = $args;

    }
    /**
     * @param string $name
     * @param $args
     * set special args
     */
    public function setSpecialArgs($name='',$args)
    {
        $this->args[$name] = $args;

    }
    /**
     * clear all args
     */
    public function clearArgs()
    {
        $this->args = '';

    }

    /**
     * set result with wp get_posts
     */
    public function setPosts()
    {
        $this->result = $this->get_posts($this->args);

    }

    /**
     * set posts with wp query_post function
     */
    public function setQueryPosts()
    {
        $this->result = $this->query_posts($this->args);
    }

    /**
     * @param $id
     * Set post by id with wp_get_post
     */
    public function setSinglePost($id)
    {
        $this->result = array( 0 => $this->get_post($id));
    }

    /**
     * set archive  with wp wp_get_archive
     */
    public function setArchive()
    {
        $this->result = wp_get_archives($this->args);
    }

    /**
     * set acf fields to post
     */
    public function formattedACF()
    {
        foreach ($this->result as &$item) {
            $item->acf = get_field_objects($item->ID);
        }
    }
    
    /**
     * set posts urls to result
     */
    public function setPostUrls()
    {
        foreach ($this->result as &$item) {
            $item->post_url = get_permalink ($item->ID);
        }
    }

    /**
     * @param int $lim
     * set post limit in result
     */
    public function setLimit($lim = 1000)
    {
        $result = [];
        $i = 0;
        foreach ($this->result as $res) {
            $result[] = $res;
            if ($i == $lim) {
                break;
            }
            $i++;
            $this->result = $result;
        }
    }

    /**
     * @param string $size
     * image size
     */
    public function setMainThumbnailUrls($size='full')
    {
        foreach ($this->result as &$item) {
            /* for using this you must have iceThemeSettingsPlugin; */
            $options = $this->getThemeOtpions();
            if(!empty($options) && $options['default_image_id'] != ''){
                $item->default_thumnail_url = image_downsize ($options['default_image_id'], $size )[0];
                $item->default_thumnail_name = explode('.', basename(get_attached_file($options['default_image_id'])))[0];
            }
            $item->main_thumnail_url = get_the_post_thumbnail_url($item->ID,$size);
            $item->main_thumnail_name = $this->getAttachmentMeta(get_post_thumbnail_id ($item->ID));
        }
    }


    public function setCustomImagelUrl($post_type, $image_id='', $image_size=null)
    {
        foreach ($this->result as &$item) {
            if (!isset($item->other_image_urls) || empty($item->other_image_urls)) {
                $item->other_image_urls = [];
            }
            if (!isset($item->other_image_names) || empty($item->other_image_names)) {
                $item->other_image_names = [];
            }
            $item->other_image_urls[$image_id] = MultiPostThumbnails::get_post_thumbnail_url($post_type, $image_id, $item->ID, $image_size);
            $item->other_image_names[$image_id] = $this->getAttachmentMeta(get_post_thumbnail_id ($item->ID));
        }
    }

    /**
     * @param $result
     * set result for other manipulations
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     * return result
     */
    public function getResult()
    {
        return $this->result;
    }
}