<?php

use IlinquaTest\Controller\PageView;
use IlinquaTest\Helper\Data;
use IlinquaTest\Model\Testing;

$testing = new Testing();

if ($_POST['test_id']) {
    $data = [];
    $data['name'] = $_POST['name'];
    $data['email'] = $_POST['email'];
    $data['test_id'] = $_POST['test_id'];
    $testing->startTesting($data);
}

global $post;
$view = new PageView();
$config = Data::getConfig('show');
$handler = $view->postsHandler;
$handler->setResult([0 =>$post]);
$handler->formattedMeta();

$context = [];

if (!empty($post)) {
    $context['test'] = $post;

    $questionsRandom = get_post_meta($post->ID, 'test_random', true);
    $testSteps  = get_post_meta($post->ID, 'test_steps', true);
    $questionsIds     = get_post_meta($post->ID, 'questions', true);
    $questionsLimit   = get_post_meta($post->ID, 'questions_count', true);

    if (count($questionsIds) == count($questionsLimit)) {
        for ($i=1; $i !=count($questionsLimit); $i++) {
            if ($questionsRandom == "y") {
                shuffle($questionsIds[$i]);
            }
            if (count($questionsIds[$i]) > $questionsLimit[$i]) {
                array_splice($questionsIds[$i], $questionsLimit[$i]);
            }
        }
    }

    $questionsTextIds = get_post_meta($post->ID, 'questions_text', true);
    $questionsTextIdsLim = get_post_meta(
        $post->ID, 'questions_text_count', true
    );

    if (count($questionsTextIds) == count($questionsTextIdsLim)) {
        for ($i=1; $i !=count($questionsTextIds); $i++) {
            if ($questionsRandom == "y") {
                shuffle($questionsTextIds[$i]);
            }
            if (count($questionsTextIds[$i]) > $questionsTextIdsLim[$i]) {
                array_splice($questionsTextIds[$i], $questionsTextIdsLim[$i]);
            }
        }
    }

    $scoresForPass = get_post_meta($post->ID, 'score_for_pass', true);
    $countQuestionsIds = count($questionsIds);

    $context['default_test_steps'] = $testSteps;

    $postQuestions = [];
    
    if ($testSteps > $countQuestionsIds) {
        $testSteps = $countQuestionsIds;
        $context['test_steps'] = $testSteps;
    }
    if (!empty($questionsIds)) {
        $i=1;
        foreach ($questionsIds as $val) {
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
            //$handler->setCustomPostMeta('right_answer');
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
    $context['questions'] = $postQuestions;
    if ($_SESSION['test_id']) {
        $context['session_test_id'] = $_SESSION['test_id'];
    }
}

$view->display('single_test.twig', ['test'=>$context]);
