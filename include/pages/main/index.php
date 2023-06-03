<?php

include SITE_DIR . 'class/DBClass.php';

$new = [
    'ID' => '5',
    'NAME' => 'TEST',
    'URL' => 'TEST',
    'CATEGORY' => 'ORIGINAL',
    'DEPTH_LEVEL' => '1',
];

$update = [
    'NAME' => 'UPDATD',
    'URL' => 'UPDTED',
    'CATEGORY' => 'UDATED',
    'DEPTH_LEVEL' => '3',
];

$getlist = [
    'SELECT' => '*',
    'FROM' => 'testTable',
];

echo '<pre>';
var_dump(DB::GetList($getlist));
echo '</pre>';





