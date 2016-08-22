<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 22.08.16
 * Time: 21:53
 */

/**
 * @global ilinqua\core\CoreTheme
 */

global $core;

use ilinqua\app\core;
use ilinqua\app\core\CoreTheme;

/**
 * Use composer
 */
if (file_exists($composer_autoload = __DIR__ . '/vendor/autoload.php')) {
    require_once $composer_autoload;
}else{
    _e('Install composer for current work');
    exit;
}

$core = new CoreTheme();