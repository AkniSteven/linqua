<?php

use IlinquaTest\Controller\PageView;
use IlinquaTest\Controller\TestingController;
use IlinquaTest\Helper\Data;
use IlinquaTest\Model\TestDb;
use ilinqua\app\Helper\Data as coreData;


global $post;
global $core;

$testDb = new TestDb();
$testing = new TestingController();
$view = new PageView();
$config = Data::getConfig('show');
$context = $core->get_context();

$handler = $view->postsHandler;
$handler->setResult([$post]);
$handler->formattedMeta();

#theme posts
$coreConfig = $core->getConfig();
$showConfig = $coreConfig->getConfig('show', 'show');
$model  = $core->getModel();

if ($_POST['test_id']) {
    $data = [];
    $data['name']    = Data::cleanString($_POST['name']);
    $data['email']   = Data::cleanString($_POST['email']);
    $data['tel']   = Data::cleanString($_POST['tel']);
    $data['test_id'] = Data::cleanString($_POST['test_id']);
    $data['realStepsCount'] = (int)Data::cleanString($_POST['realStepsCount']);
    $testing->startTesting($data);
}

if ($_POST['restart_test']) {
    global $wp;
    $currentUrl = home_url(add_query_arg(array(),$wp->request));
    if ($_SESSION['tester_id']) {
        session_destroy();
        header ('Location: ' . $currentUrl);
    }
}

if (!empty($post)) {
    $context['test'] = $post;

    $questionsRandom  = get_post_meta($post->ID, 'test_random', true);
    $testSteps        = get_post_meta($post->ID, 'test_steps', true);
    $questionIds     = get_post_meta($post->ID, 'questions', true);
    $questionLimit   = get_post_meta($post->ID, 'questions_count', true);

    processQuizes($questionIds, $questionLimit, $questionsRandom == "y");

    $questionsTextIds = get_post_meta($post->ID, 'questions_text', true);
    $questionsTextIdsLim = get_post_meta(
        $post->ID, 'questions_text_count', true
    );

    processQuizes($questionsTextIds, $questionsTextIdsLim, $questionsRandom == "y");

    $scoresForPass = get_post_meta($post->ID, 'score_for_pass', true);
    $countQuestionsIds = count($questionIds);

    $context['default_test_steps'] = $testSteps;

    $postQuestions = [];

    if ($testSteps > $countQuestionsIds) {
        $testSteps = $countQuestionsIds;
        $context['test_steps'] = $testSteps;
    }

    if (!empty($questionIds)) {
        $i=1;
        foreach ($questionIds as $val) {
            $handler->setArgs(
                [
                    "posts_per_page" => -1,
                    "post_type" =>"test_question",
                    'post__in' => $val
                ]
            );

            $handler->setPosts();
            $handler->formattedMeta();
            $handler->setCustomPostMeta('question_type');
            $handler->setCustomPostMeta('answer_case');
            $handler->setMainThumbnailUrls();
            $postQuestions[$i] = $handler->getResult();
            if ($questionsRandom == "y") {
                shuffle($postQuestions[$i]);
            }
            $i++;
        }
    }
    if (!empty($questionsTextIds)) {
        if (!empty($postQuestions)) {
            $i=1;
            foreach ($questionsTextIds as $val) {
                $handler->setArgs(
                    [
                        "posts_per_page" => -1,
                        "post_type" =>"test_question",
                        'post__in' => $val
                    ]
                );

                $handler->setPosts();
                $handler->formattedMeta();
                //$handler->setCustomPostMeta('question_score');
                $handler->setCustomPostMeta('question_type');
                $handler->setCustomPostMeta('answer_case');
                $handler->setMainThumbnailUrls();
                $textPosts = $handler->getResult();

                if (!empty($postQuestions[$i]) && !empty($textPosts)) {
                    foreach ($textPosts as $post) {
                        array_push(
                            $postQuestions[$i],
                            $post
                        );
                    }
                }
                $i++;
            }
        }
    }

    if ($testSteps > 0 && count($postQuestions) > $testSteps) {
        array_splice($postQuestions, $testSteps);
    }
    $context['realStepsCount'] = count($postQuestions);

    $allQuestionsCount = 0;
    $countQuestionsByStep = [];

    foreach ($postQuestions as $postQuestion) {
        $allQuestionsCount += count($postQuestion);
        $countQuestionsByStep[] = count($postQuestion);
    }

    $context['countQuestionsByStep'] = implode(',', $countQuestionsByStep);
    $context['allQuestionsCount'] = $allQuestionsCount;

    $context['questions'] = $postQuestions;
    $context['already_passed'] = 0;
    if ($_SESSION['test_id']) {
        $context['session_test_id'] = $_SESSION['test_id'];
        $testerID  = $_SESSION['tester_id'];
        $currentTestData = $testDb->getTestById($testerID)[0];
        if ($currentTestData['test'] == $post->ID) {
            $context['already_passed'] = 1;
        }
    }
}
$context['ajax_url'] = get_site_url() . '/wp-admin/admin-ajax.php';
$context['last_questions_ids'] = [];

if (!empty($context['questions'])) {
    foreach ($context['questions'] as $key=>$level) {
        if (is_array($level)) {
            $context['last_questions_ids'][$key] = end($level)->ID;
        }
    }
}

if (!empty($context['last_questions_ids'])) {
    $_SESSION['last_questions_ids'] = $context['last_questions_ids'];
}


$pageLangTerms = coreData::getPostTermIds($post, 'language');
if (!empty($pageLangTerms)) {
    $taxQuery['relation'] = "AND";
    $taxQuery[] = [
        'taxonomy' => 'language',
        'field' => 'term_id',
        'terms' => $pageLangTerms
    ];

}


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
    $context['articleList'] = $model->getResult();
}

if ($context['articleList']) {
    foreach ($context['articleList'] as &$post) {
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

$view->display('single_test.twig', $context);

// Function name should be changed to more specific one.
function processQuizes($questionIds, $questionLimit, $isRandom)
{
    if (count($questionIds) == count($questionLimit)) {
        for ($i = 1; $i != count($questionLimit); $i++) {
            if ($isRandom) {
                shuffle($questionIds[$i]);
            }
            if (count($questionIds[$i]) > $questionLimit[$i]) {
                array_splice($questionIds[$i], $questionLimit[$i]);
            }
        }
    }
}
