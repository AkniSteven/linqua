<?php
/* Template Name: Test result Template */

use IlinquaTest\Model\TestDb;
use ilinqua\app\Helper\Data;
use IlinquaTest\Model\Testing;

global $core;
global $post;

$context = $core->get_context();
$model  = $core->getModel();
$config = $core->getConfig();
$testDb = new TestDb();
$testing = new Testing();

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
    $context['total_score'] = 0;
    if (!empty($testAnswers)) {
        $context['test_answers_from_questions'] = $testing->getAnswersScore($testAnswers);
        foreach ($testAnswers as &$answers) {
            $answers = $testing->formatResultAnswers($answers);
            $levelPoints = $testing->calculateAnswersScore($answers);
            $context['total_score'] += $levelPoints;
        }
    }
    $context['test_answers'] = $testAnswers ? $testAnswers : [];
}

#Meta data
$metaTitle = $context['page']->acf['meta_title']['value'];
$context['meta_title'] = $metaTitle ? $metaTitle : $context['page']->post_title;

$metaDescription = $context['page']->acf['meta_description']['value'];
$context['meta_description'] = $metaDescription ? $metaDescription : '';

$core->render('test-result-template.twig', $context);