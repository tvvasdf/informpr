<?php

$test = new Main;

$test->IncludeComponent(
    'menu',
    'informpr_top',
    [
        'MENU_TYPE' => 'top',
    ]);




/*
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

$delete = [
    'where' => [
        'field' => 'DEPTH_LEVEL',
        'cond' => '=',
        'value' => '3',
    ],
];

$needle = [
    'where'
];

/*
$test = DB::AddItem($update, 'testTable');

echo '<pre>';
var_dump($test);
echo '</pre>';


$test = DB::DeleteItem($delete,'testTable', $needle);
echo '<pre>';
var_dump($test);
echo '</pre>';
/*
$test = DB::GetList($get, 'testTable');

echo '<pre>';
var_dump($test);
var_dump($test->fetchAll());
echo '</pre>';


*/

