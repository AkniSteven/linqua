<?php
/*
Plugin Name: Ice theme settings
Plugin URI:
Description: Create custom theme settings
Version: 0.0.1
Author: Stevenaknidev@gmail.com
Author URI: https://ua.linkedin.com/in/steve-arshinikov-5a4184aa
*/
use IceThemeSettings\Model\Ice_Theme_Settings;

define('TEMPLATE_PATH' ,   __DIR__ . '/views/templates');
/**
 * Use composer
 */
if (file_exists($composer_autoload = __DIR__ . '/vendor/autoload.php')) {
    require_once $composer_autoload;
}else{
    _e('Install composer for current work');
    exit;
}

$loader = new Twig_Loader_Filesystem( TEMPLATE_PATH);
$twig = new Twig_Environment($loader, array(
    'cache' => 'compilation_cache',
));

$settings = new Ice_Theme_Settings();
$page =  $twig->render('setting.twig', array('name' => 'Fabien'));
$settings->display_page($page);


