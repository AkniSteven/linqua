<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 22.08.16
 * Time: 23:15
 */

namespace ilinqua\app\Model;

use Timber\Timber;

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