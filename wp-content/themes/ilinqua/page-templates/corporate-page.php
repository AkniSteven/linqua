<?php
/* Template Name:Corporate Template */

use ilinqua\app\Helper\Data;

global $core;
global $post;

$context = $core->get_context();
$model  = $core->getModel();
$config = $core->getConfig();
$showConfig = $config->getConfig('show', 'show');
$pageLangTerms = [];
$taxQuery = [];
$categoriesFilters=[];

if ($post && $post->post_type == 'page') {
    $model->setResult([$post]);
    $model->setMainThumbnailUrls();
    $model->formattedAcf();
    $context['page'] = $model->getResult()[0];
    $pageLangTerms = Data::getPostTermIds($post, 'language');
    $context['color'] = $context['page']->acf['page_background']['value']
        ? $context['page']->acf['page_background']['value'] : '';
    $context['background_image_url'] = $context['page']->main_thumnail_url
        ? : '';
}

if (!empty($pageLangTerms)) {
    $taxQuery['relation'] = "AND";
    $taxQuery[] = [
        'taxonomy' => 'language',
        'field' => 'term_id',
        'terms' => $pageLangTerms
    ];

}
#courses
if ($showConfig['courses']) {
    $courses = $showConfig['courses'];
    $model->setArgs($courses);
    if (!empty($taxQuery)) {
        $model->setSpecialArgs("relations", "AND");
        $model->setSpecialArgs(
            "tax_query", $taxQuery
        );
    }

    $model->setPosts();
    $model->setPostUrls();
    $model->formattedAcf();
    $context['coursesPosts'] = $model->getResult();
}

#posts
if ($showConfig['posts']) {
    $posts = $showConfig['posts'];
    $model->setArgs($posts);
    if (!empty($taxQuery)) {
        $model->setSpecialArgs("relations", "AND");
        $model->setSpecialArgs(
            "tax_query", $taxQuery
        );
    }
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
                $categoriesFilters[$category->term_id] = $category;

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

$context['categories'] = $categoriesFilters;

#Meta data
$metaTitle = $context['page']->acf['meta_title']['value'];
$context['meta_title'] = $metaTitle ? $metaTitle : $context['page']->post_title;

$metaDescription = $context['page']->acf['meta_description']['value'];
$context['meta_description'] = $metaDescription ? $metaDescription : '';

$core->render('corporate-template.twig', $context);