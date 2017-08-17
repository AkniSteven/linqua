<?php
/* Template Name: Contact Template */

global $core;
global $post;

$context = $core->get_context();
$model  = $core->getModel();
$config = $core->getConfig();

if ($post && $post->post_type == 'page') {
    $model->setResult(['0'=>$post]);
    $model->formattedACF();
    $post = $model->getResult();
    $context['page'] = $post[0];
}

#Meta data
$metaTitle = $context['page']->acf['meta_title']['value'];
$context['meta_title'] = $metaTitle ? $metaTitle : $context['page']->post_title;

$metaDescription = $context['page']->acf['meta_description']['value'];
$context['meta_description'] = $metaDescription ? $metaDescription : '';

$core->render('contact-template.twig', $context);