<?php

if (!$arParams['MENU_TYPE']){
    throw new Exception('Ошибка: Не указан обязательный параметр "Тип меню" (MENU_TYPE)');
}

$from = "menu_" . $arParams['MENU_TYPE'];
$params = [
    "select" => "*",
];

DB::GetList($params, $from);

require 'template.php';