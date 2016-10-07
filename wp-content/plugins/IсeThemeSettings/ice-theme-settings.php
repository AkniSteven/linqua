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

define('TEMPLATE_PATH_SETTINGS', __DIR__ . '/views/templates');
/**
 * Use composer
 */
if (file_exists($composerAutoload = __DIR__ . '/vendor/autoload.php')) {
    require_once $composerAutoload;
} else {
    _e('Install composer for current work');
    exit;
}

function clear(&$str)
{
    $str =  trim($str);
}

$loader = new Twig_Loader_Filesystem(TEMPLATE_PATH_SETTINGS);
$twig = new Twig_Environment($loader);

$settings = new Ice_Theme_Settings();

$options = (array) get_option('ice-theme-settings');
$succes = '';
$walk = &$options;
array_walk_recursive($walk, 'clear');

if ($_REQUEST['settings-updated'] != '' ) {
    $success = 'Success!';
}
$page = $twig->render(
    'setting.twig', ['theme_options' => $options, 'success_msg' => $success]
);
$settings->set_page($page);



