<?php

include SITE_DIR . 'func/DBResult.php';

$param = [
    'select' => '*',
    'from' => 'testTable',
];

$test = new DBResult();

$dbRes = $test->GetList($param);



echo '<pre>';
var_dump($dbRes);
echo '</pre>';