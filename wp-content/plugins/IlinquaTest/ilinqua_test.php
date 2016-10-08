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
use IlinquaTest\Model\Metabox;

define('TEMPLATE_PATH_TEST', __DIR__);

/**
 * Use composer
 */
if (file_exists($composerAutoload = __DIR__ . '/vendor/autoload.php')) {
    require_once $composerAutoload;
} else {
    _e('Install composer for current work');
    exit;
}

$constructor = new Construct;
$metabox = new Metabox('test_question', __('Test Questions Settings'));
$loader = new Twig_Loader_Filesystem(TEMPLATE_PATH_TEST . '/views/templates/');
$twig = new Twig_Environment($loader);

$options = [];
$options['post_id'] = $_GET['post'];
$options['meta'] = get_post_meta($options['post_id']);
$options['meta']['answer_case'] = get_post_meta(
    $options['post_id'], 'answer_case', true
);
$options['meta']['right_answer'] = get_post_meta(
    $options['post_id'], 'right_answer', true
);
#render view for metabox
$metaboxDisplay = $twig->render(
    'metabox.twig', ['options' => $options]
);
$metabox->set_view($metaboxDisplay);