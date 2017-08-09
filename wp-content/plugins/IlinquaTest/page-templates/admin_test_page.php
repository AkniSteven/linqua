<?php

use IlinquaTest\Controller\PageView;
use IlinquaTest\Model\TestDb;

$dbModel = new TestDb();
$view = new PageView();
if ($_POST['update_status']) {
    if ($_POST['id'] && $_POST['status'] !=='') {
        $dbModel->update_status($_POST['id'], $_POST['status']);
    }
}
if ($_POST['delete_test']) {
    if ($_POST['id'] !== '') {
        $dbModel->deleteTest($_POST['id']);
    }
}
$context = [];
$allTests = $dbModel->getTests();

if (!empty($allTests)) {
    $context['allTests'] = $allTests;
}

$context['test_link'] = get_permalink(
    get_option('test-config')['test_result_page_id']
);

$context['test_label'] = $context['test_link']
    ? __('view test') : __('please configure test result page');

$view->display('admin_test_page.twig', ['test'=>$context]);
