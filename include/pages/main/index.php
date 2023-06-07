<?php

$test = new Main;


$testExc = new Exception('Test');

echo '<pre>';
var_dump($testExc->getMessage());
echo '</pre>';

throw $testExc;
//trigger_error("Не могу поделить на ноль");

echo '<pre>';
var_dump($test->IncludeComp('menu', '', ['PARAM1' => 1, 'PARAM2' => 2]));
echo '</pre>';


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

