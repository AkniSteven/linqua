<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 29.08.16
 * Time: 19:59
 */

/* Template Name: Home Template */

global $core;
global $post;

$context = $core->get_context();
$model  = $core->getModel();
$config = $core->getConfig();
$showConfig = $config->getConfig('show', 'show');

if ($post && $post->post_type == 'page') {
    $context['page'] = $post;
}

#courses
if ($showConfig['courses']) {
    $courses = $showConfig['courses'];
    $model->setArgs($courses);
    $model->setPosts();
    $model->setPostUrls();
    $model->formattedAcf();
    $context['coursesPosts'] = $model->getResult();
}



$core->render('home-template.twig', $context);