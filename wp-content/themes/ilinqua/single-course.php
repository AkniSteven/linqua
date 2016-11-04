<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 07.10.16
 * Time: 0:49
 */
/* Template Name: Single-course Template */

global $core;
global $post;

$context = $core->get_context();
$model  = $core->getModel();
$config = $core->getConfig();

if ($post) {
    $model->setResult(['0'=>$post]);
    $model->formattedACF();
    $post = $model->getResult();
    $context['course'] = $post[0];
}
if (!empty($context['course'])) {
    $authorID = $context['course']->post_author;
    if ($authorID) {
       $authorData = get_user_by(
           'ID', $authorID
       );
       $authorThumb =   get_field('image', 'user_2')['sizes']['thumbnail'];
        
       $context['author_name'] = $authorData ? $authorData->display_name : '';
       $context['author_thumb'] = $authorThumb ? $authorThumb : '';
    }
}

$core->render('single-course.twig', $context);