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

$core->render('contact-template.twig', $context);