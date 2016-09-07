<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 29.08.16
 * Time: 19:59
 */


global $core;

$context = $core->get_context();
$model  = $core->getModel();
$config = $core->getConfig();

$core->render('single.twig', $context);