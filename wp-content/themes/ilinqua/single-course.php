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

$core->render('single-course.twig', $context);