<?php

/*
  Plugin Name: Original texts Yandex WebMaster
  Plugin URI: http://www.zixn.ru/plagin-originalnye-teksty-yandex.html
  Description: Позволяет добавлять ваши записи в "Оригинальные тексты Yandex Webmaster"
  Version: 1.7
  Author: Djo
  Author URI: http://zixn.ru
 */

/*  Copyright 2016  Djo  (email: izm@zixn.ru)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * 
 */
require_once (WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)) . '/inc/ortext-core-class.php');
require_once (WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)) . '/inc/ortext-function-class.php'); //Основной функционал плагина
require_once (WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)) . '/inc/javascript-class.php');

$ortextbase = new OrTextBase();
$ortextjs = new OrtextJavaScript();
register_deactivation_hook(__FILE__, array($ortextbase, 'deactivationPlugin'));

//register_activation_hook(__FILE__, array($ortextbase, 'addCronWP'));
//add_filter('cron_schedules', array($ortextbase, 'cronTimeList', 10, 2)); //Задания крон