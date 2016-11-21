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
$context = [];
$allTests = $dbModel->getTests();

if (!empty($allTests)) {
    $context['allTests'] = $allTests;
}
$view->display('admin_test_page.twig', ['test'=>$context]);
