<?php
/*
Plugin Name: ilinqua test
Plugin URI:
Description: Plugin for testing
Version: 0.0.1
Author: Stevenaknidev@gmail.com
Author URI: https://ua.linkedin.com/in/steve-arshinikov-5a4184aa
*/
use IlinquaTest\Model\Construct;

define('TEMPLATE_PATH_TEST' ,   __DIR__ );

/**
 * Use composer
 */
if (file_exists($composer_autoload = __DIR__ . '/vendor/autoload.php')) {
    require_once $composer_autoload;
}else{
    _e('Install composer for current work');
    exit;
}

$constructor = new Construct;

$loader = new Twig_Loader_Filesystem( TEMPLATE_PATH_TEST . '/views/templates/');
$twig = new Twig_Environment($loader);
