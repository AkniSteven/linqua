<?php

use IlinquaTest\Controller\PageView;
use IlinquaTest\Helper\Data;

global $post;
$view = new PageView();
$config = Data::getConfig('show');
$handler = $view->postsHandler;
$handler->setResult([0 =>$post]);
$handler->formattedMeta();

$context = [];

if (!empty($post)) {
    $textSteps        = get_post_meta($post->ID, 'test_steps', true);
    $questionsIds     = get_post_meta($post->ID, 'questions', true);
    $questionsTextIds = get_post_meta($post->ID, 'questions_text', true);
    $scoresForePass   = get_post_meta($post->ID, 'score_for_pass', true);
}

$view->display('single_test.twig', ['context'=>'test']);
