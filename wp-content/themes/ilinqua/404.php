<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 22.08.16
 * Time: 23:45
 */

/* Template Name: 404 */
global $core;

$context = $core->get_context();

$core->render('404.twig', $context);
