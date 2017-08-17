<?php
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
    $bannerImagePostType = $config->getConfig(
        "postImages", "style_config"
    )["banner_image"]["post_type"];
    $storyImagePostType = $config->getConfig(
        "postImages", "style_config"
    )["story_image"]["post_type"];

    $model->setResult(['0'=>$post]);
    $model->formattedACF();
    $model->setMainThumbnailUrls();
    $model->setCustomImagelUrl($backGroundImagePostType, "background_image");
    $model->setCustomImagelUrl($mainImagePostType, "main_image");
    $model->setCustomImagelUrl($mainImagePostType, "banner_image");
    $model->setCustomImagelUrl($mainImagePostType, "story_image");
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
       $authorThumb =   get_field(
           'image', "user_{$authorID}"
       )['sizes']['thumbnail'];
        
       $context['author_name'] = $authorData
           ? $authorData->display_name : '';
       $context['author_thumb'] = $authorThumb ? $authorThumb : '';
    }

    $currentLangIds = wp_get_post_terms(
        $context['course']->ID,
        'language',
        ['fields' => 'ids', 'hide_empty'=>true]
    );

    $currentLangId = !empty($currentLangIds) ? $currentLangIds[0] : '';
    $context['catalog_url'] = '';
    #course url
    if (!empty($currentLangId)) {
        if (!empty($context['home_pages'])) {
            foreach ($context['home_pages'] as $page) {
                $homePageIds = wp_get_post_terms(
                    $page->ID,
                    'language',
                    ['fields' => 'ids', 'hide_empty'=>true]
                );
                $homePageId = !empty($homePageIds) ? $homePageIds[0] : '';
                if ($homePageId !='' && $homePageId == $currentLangId) {
                   $context['catalog_url'] = $page->post_url;
                }
            }
        }
    }
}

#Meta data
$metaTitle = $context['course']->acf['meta_title']['value'];
$context['meta_title'] = $metaTitle
    ? $metaTitle
    : $context['course']->post_title;

$metaDescription = $context['course']->acf['meta_description']['value'];
$context['meta_description'] = $metaDescription ? $metaDescription : '';

$core->render('single-course.twig', $context);