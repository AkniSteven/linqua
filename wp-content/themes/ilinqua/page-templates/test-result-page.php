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
}

$core->render('test-result-template.twig', $context);