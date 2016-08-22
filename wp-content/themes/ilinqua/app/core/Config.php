<?php

namespace ilinqua\app\core;

class Config
{
    /**
     * @param string $file array with config params
     *
     * @param string $dir directory path
     * @return config Std or empty array
     */
    public $config;
    
    public function getConfig($file, $dir ='')
    {

        if($dir !=''){
            $file = get_template_directory() . '/app/config/' . $dir .'/' . $file . '.json';
        }
        else{
            $file = get_template_directory() . '/app/config/'  . $file . '.json';
        }
        if (file_exists($file)) {
            $this->config = json_decode(file_get_contents($file), true);
        }
        else{
            $this->config = array();
        }
        return $this->config;
    }
    
}