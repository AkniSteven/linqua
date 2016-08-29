<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 29.08.16
 * Time: 19:59
 */

/* Template Name: Home Template */

global $core;

$context = $core->get_context();
$model  = $core->getModel();
$config = $core->getConfig();

$core->render('home-template.twig', $context);