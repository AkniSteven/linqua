<?php
/* Template Name: Test result Template */

use IlinquaTest\Model\TestDb;
use ilinqua\app\Helper\Data;

global $core;
global $post;

$context = $core->get_context();
$model  = $core->getModel();
$config = $core->getConfig();
$testDb = new TestDb();

if ($post && $post->post_type == 'page') {
    $model->setResult(['0'=>$post]);
    $model->formattedACF();
    $post = $model->getResult();
    $context['page'] = $post[0];
}

$role = Data::getUserRole();
$testId = $_GET['testId'];


if ($role != 'Administrator' || !$testId) {
    wp_redirect(home_url());
    exit;
}

$currentTestData = $testDb->getTestById($testId)[0];
if ($currentTestData['test']) {
    $context['name'] = Data::cleanString($currentTestData['name']);
    $context['email'] = Data::cleanString($currentTestData['email']);
    $context['testID'] = Data::cleanString($currentTestData['testId']);
    $testAnswers = unserialize($currentTestData['info']);

    if (!empty($testAnswers)) {
        foreach ($testAnswers as &$answers) {
            foreach ($answers as &$answer) {
                if ($answer['id']) {
                    $question = get_post($answer['id']);
                    $questionAnswers = get_post_meta($answer['id'], 'answer_case', true);
                    if (is_array($answer['right_answer'])) {
                        foreach ($answer['right_answer'] as &$right_answer) {
                            $right_answer = $questionAnswers[$right_answer];
                        }
                    } else {
                        $answer['right_answer'] = $questionAnswers[$answer['right_answer']];
                    }
                    if (is_array($answer['user_answer'])) {
                        foreach ($answer['user_answer'] as &$user_answer) {
                            $user_answer = $questionAnswers[$user_answer];
                        }
                    } else {
                        $answer['user_answer'] = $questionAnswers[$answer['user_answer']];
                    }
                 }
            }
        }
    }
    $context['test_answers'] = $testAnswers ? $testAnswers : [];
}

$core->render('test-result-template.twig', $context);