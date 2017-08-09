<?php

use IlinquaTest\Controller\PageView;

global $post;
global $core;

$view = new PageView();

if (!isset($context)) {
    $context = [];
}

$context['options'] = (array) get_option('test-config');
$context['options_group'] = 'test-config';

$context['labels'] = [
    'test_result_page_id' => __('Test result page id'),
    'save_text' => __('Save'),
    'title' => __('Test configurations')
];

ob_start();
?>
<form method="post" action="options.php" class="settings-form">
    <?php
    settings_fields($context['options_group']);
    $view->display('config.twig', $context);
    ?>
</form>
<?php
return ob_get_clean();
?>
