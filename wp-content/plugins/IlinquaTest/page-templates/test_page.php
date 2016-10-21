<?php

use IlinquaTest\Controller\PageView;
use IlinquaTest\Helper\Data;

global $post;

$view = new PageView();
$config = Data::getConfig('show');
$handler = $view->postsHandler;
$context = [];
$testPosts = [];

if ($post) {
    $context['page'] = $post;
}
if (!empty($config['test'])) {
    $handler->setArgs($config['test']);
    $handler->setPosts();
    $handler->setPostUrls();
    $testPosts = $handler->getResult();
}

$context['test_posts'] = $testPosts;

$view->display('all_tests_page.twig', $context);
