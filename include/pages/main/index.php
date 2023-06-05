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
    'NAME' => 'U D',
    'URL' => 'UP2 ED',
    'CATEGORY' => 'UD D',
    'DEPTH_LEVEL' => '5',
];


$get = [
    'select' => '*',
    'where' => [
        'field' => 'DEPTH_LEVEL',
        'cond' => '=',
        'value' => '3',
    ],

];

/*
$test = DB::AddItem($update, 'testTable');

echo '<pre>';
var_dump($test);
echo '</pre>';
*/


$test = DB::GetList($get, 'testTable');

echo '<pre>';
var_dump($test);
var_dump($test->fetchAll());
echo '</pre>';




