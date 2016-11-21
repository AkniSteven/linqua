<?php

namespace IlinquaTest\Model;

class PostsHandler
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
    private $_result;

    /**
     * @var $args
     * params to get result
     */
    private $_args;

    /**
     * @param array $args
     * set main args
     */
    public function setArgs($args=[])
    {
        $this->_args = $args;

    }

    /**
     * @param string $name
     * @param $args
     * set special args
     */
    public function setSpecialArgs($name='', $args)
    {
        $this->_args[$name] = $args;

    }
    /**
     * clear all args
     */
    public function clearArgs()
    {
        $this->_args = '';

    }

    /**
     * set result with wp get_posts
     */
    public function setPosts()
    {
        $this->_result = $this->get_posts($this->_args);

    }

    /**
     * set posts with wp query_post function
     */
    public function setQueryPosts()
    {
        $this->_result = $this->query_posts($this->_args);
    }

    /**
     * @param $id
     * Set post by id with wp_get_post
     */
    public function setSinglePost($id)
    {
        $this->_result = array( 0 => $this->get_post($id));
    }

    /**
     * set archive  with wp wp_get_archive
     */
    public function setArchive()
    {
        $this->_result = wp_get_archives($this->_args);
    }

    /**
     * set acf fields to post
     */
    public function formattedACF()
    {
        foreach ($this->_result as &$item) {
            $item->acf = get_field_objects($item->ID);
        }
    }

    /**
     * @param $name
     * set custom post Meta
     */
    public function setCustomPostMeta($name)
    {
        foreach ($this->_result as &$item) {
            $item->meta[$name] = get_post_meta($item->ID, $name, true);
        }
    }
    /**
     * set meta fields to post
     */
    public function formattedMeta()
    {
        foreach ($this->_result as &$item) {
            $item->meta = get_post_meta($item->ID);
        }
    }

    /**
     * @param string $size
     * image size
     */
    public function setMainThumbnailUrls($size='full')
    {
        foreach ($this->_result as &$item) {
            $item->main_thumnail_url = get_the_post_thumbnail_url($item->ID,$size);
            $item->main_thumnail_name = $this->getAttachmentMeta(get_post_thumbnail_id ($item->ID));
        }
    }
    
    /**
     * set posts urls to result
     */
    public function setPostUrls()
    {
        foreach ($this->_result as &$item) {
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
        foreach ($this->_result as $res) {
            $result[] = $res;
            if ($i == $lim) {
                break;
            }
            $i++;
            $this->_result = $result;
        }
    }

    /**
     * @param $result
     * set result for other manipulations
     */
    public function setResult($result)
    {
        $this->_result = $result;
    }

    /**
     * @return mixed
     * return result
     */
    public function getResult()
    {
        return $this->_result;
    }
}