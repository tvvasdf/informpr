<?php

include SITE_DIR . 'func/MenuAction.php';


$test = new Menu('top');
$new = [
    'ID' => '2',
    'NAME' => 'TEST',
    'URL' => 'TEST',
    'CATEGORY' => 'ORIGINAL',
    'DEPTH_LEVEL' => '1',
];

echo '<pre>';
var_dump($test->includeComponent());
echo '</pre>';

