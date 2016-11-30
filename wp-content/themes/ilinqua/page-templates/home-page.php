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

#posts
if ($showConfig['posts']) {
    $posts = $showConfig['posts'];
    $model->setArgs($posts);
    $model->setPosts();
    $model->setMainThumbnailUrls();
    $model->setPostUrls();
    $model->formattedAcf();
    $context['posts'] = $model->getResult();
}
if ($context['posts']) {
    foreach ($context['posts'] as &$post) {
        $post->dataFIlter = '';
        $post->dataEvent = false;
        $categories = get_the_category($post->ID);
        if (!empty($categories)) {
            foreach ($categories as $category) {
                if ($post->dataFilter == '') {
                    $post->dataFilter = $category->slug;
                } else {
                    $post->dataFilter .=
                        " $category->slug";
                }
                if ($category->slug == "events") {
                    $post->dataEvent = true;
                    $post->dataEventDate = $core->specialDateFormat(
                        $post->acf['event_date']['value']
                    );
                }
            }
        }
    }
    
}

$context['categories'] =  get_categories();


$core->render('home-template.twig', $context);