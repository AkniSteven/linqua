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
    $backGroundImagePostType = $config->getConfig(
        "postImages", "style_config"
    )["background_image"]["post_type"];
    
    $mainImagePostType = $config->getConfig(
        "postImages", "style_config"
    )["main_image"]["post_type"];
    
        
    $model->setResult(['0'=>$post]);
    $model->formattedACF();
    $model->setMainThumbnailUrls();
    $model->setCustomImagelUrl($backGroundImagePostType, "background_image");
    $model->setCustomImagelUrl($mainImagePostType, "main_image");
    $post = $model->getResult();
    $context['course'] = $post[0];
}
if (!empty($context['course'])) {


    $byTheTheme = $context['course']->acf['by_the_theme']['value'];
    if (!empty($byTheTheme)) {
        $model->setResult($byTheTheme);
        $model->setPostUrls();
        $model->formattedACF();
        $model->setMainThumbnailUrls();
        $byTheTheme = $model->getResult();
    }
    
    
    $context['by_the_theme'] = $byTheTheme;
    
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