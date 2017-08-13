<?php

use IlinquaTest\Controller\PageView;
use IlinquaTest\Helper\Data;

global $post;
global $core;

$view = new PageView();
$config = Data::getConfig('show');
$handler = $view->postsHandler;
$context = $core->get_context();
$testPosts = [];

if ($post) {
    $context['page'] = $post;
}

$context['alternative_title'] = get_post_field('alternative_title');

if (!empty($config['test'])) {
    $handler->setArgs($config['test']);
    $handler->setPosts();
    $handler->setPostUrls();
    $testPosts = $handler->getResult();
}

#header menu
$headerMenuLocation =  get_nav_menu_locations()['primary-header-menu'];
if ($headerMenuLocation !== null) {
    $context['primary_header_menu'] = wp_get_nav_menu_items(
        $headerMenuLocation
    );
}




$context['site_url'] = get_site_url();
$context['test_posts'] = $testPosts;

$view->display('all_tests_page.twig', $context);
