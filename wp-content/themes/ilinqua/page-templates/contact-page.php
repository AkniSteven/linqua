<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 29.08.16
 * Time: 19:59
 */

/* Template Name: Contact Template */

global $core;
global $post;

$context = $core->get_context();
$model  = $core->getModel();
$config = $core->getConfig();

if($post && $post->post_type == 'page'){
    $context['page'] = $post;
}

$core->render('contact-template.twig', $context);