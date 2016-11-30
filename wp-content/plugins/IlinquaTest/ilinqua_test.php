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
use IlinquaTest\Model\QuestionsMetabox;
use IlinquaTest\Model\TestMetabox;
use IlinquaTest\Controller\TestingController;

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

$loader = new Twig_Loader_Filesystem(TEMPLATE_PATH_TEST . '/views/templates/');
$twig = new Twig_Environment($loader);

$constructor = new Construct;

$qMetabox = new QuestionsMetabox(
    'test_question', __('Test Questions Settings')
);

$tMetabox = new TestMetabox(
    'test', __('Test Settings')
);

$options = [];
$options['post_id'] = $_GET['post'];
$options['post_type'] = get_post_type($options['post_id']);

$options['meta'] = get_post_meta($options['post_id']);

$terms = $tMetabox->getQuestionsTerms();

$options['question_terms'] = $terms;

switch($options['post_type']){
    case 'test_question':
        #metabox for questions
        $options['meta']['answer_case'] = get_post_meta(
            $options['post_id'], 'answer_case', true
        );

        $options['meta']['right_answer'] = get_post_meta(
            $options['post_id'], 'right_answer', true
        );
        break;
    case 'test':
        $options['meta']['questions_terms'] = get_post_meta(
            $options['post_id'], 'answer_case', true
        );
        break;
}

#render view for questions metabox
$qMetaboxDisplay = $twig->render(
    'questionsMetabox.twig', ['options' => $options]
);
$qMetabox->set_view($qMetaboxDisplay);

#render for tests metabox
$tMetaboxDisplay = $twig->render(
    'testMetabox.twig', ['options' => $options]
);

$tMetabox->set_view($tMetaboxDisplay);

add_action(
    'wp_ajax_addTestStep',
    'addTestStep'
);
add_action(
    'wp_ajax_nopriv_addTestStep',
    'addTestStep'
);

function addTestStep()
{
    $testing = new TestingController;
    $testing->addTestStep();

}