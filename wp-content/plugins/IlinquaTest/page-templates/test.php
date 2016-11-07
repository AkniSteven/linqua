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
    $context['test'] = $post;

    $testSteps        = get_post_meta($post->ID, 'test_steps', true);
    $context['default_test_steps'] = $testSteps;
    $questionsIds     = get_post_meta($post->ID, 'questions', true);
    $questionsTextIds = get_post_meta($post->ID, 'questions_text', true);
    $scoresForPass    = get_post_meta($post->ID, 'score_for_pass', true);
    $countQuestionsIds = count($questionsIds);
    if ($testSteps > $countQuestionsIds) {
        $testSteps = $countQuestionsIds;
        $context['test_steps'] = $testSteps;
    }

}

$view->display('single_test.twig', ['test'=>$context]);
