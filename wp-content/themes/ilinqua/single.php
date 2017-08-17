<?php
/* Template Name: Single-article Template */
use ilinqua\app\Helper\Data;

global $core;
global $post;

$context = $core->get_context();
$model  = $core->getModel();
$config = $core->getConfig();

$lang['name'] = '';
$lang['link'] = '';

if ($post) {
    /*
    $postLangTerms = Data::getPostTermIds($post, 'language');
    if ($postLangTerms) {
        if (count($postLangTerms) > 1) {
            $cat = new WPSEO_Primary_Term('language', $post->ID);
            $cat = $cat->get_primary_term();
            if ($cat != '') {
                $catObj = $core->get_term(12);
                $lang['name'] = $catObj->name;
                $lang['link'] = Data::getTermPermalink($catObj,'language');
            }
//            $catName = get_cat_name($cat);
        } else {

        }
    }
*/

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
    $context['article'] = $post[0];
}
if (!empty($context['article'])) {


    $byTheTheme = $context['article']->acf['by_the_theme']['value'];
    if (!empty($byTheTheme)) {
        $model->setResult($byTheTheme);
        $model->setPostUrls();
        $model->formattedACF();
        $model->setMainThumbnailUrls();
        $byTheTheme = $model->getResult();
    }


    $context['by_the_theme'] = $byTheTheme;

    $authorID = $context['article']->post_author;
    if ($authorID) {
        $authorData = get_user_by(
            'ID', $authorID
        );
        $authorThumb =   get_field(
            'image', "user_{$authorID}"
        )['sizes']['thumbnail'];

        $context['author_name'] = $authorData ? $authorData->display_name : '';
        $context['author_thumb'] = $authorThumb ? $authorThumb : '';
    }
    
    if ($lang['name'] !='' && $lang['link'] !='') {
        $context['label'] = $lang;
    }
}

#Meta data
$metaTitle = $context['article']->acf['meta_title']['value'];
$context['meta_title'] = $metaTitle
    ? $metaTitle
    : $context['article']->post_title;

$metaDescription = $context['article']->acf['meta_description']['value'];
$context['meta_description'] = $metaDescription ? $metaDescription : '';

$core->render('single.twig', $context);