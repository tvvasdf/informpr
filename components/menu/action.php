<?php
/**
 * $_POST[
 *    'menu-type' string - Тип меню
 *    'params' array - Массив параметров
 *    'action' string - Тип действия
 * ]
 **/

if ($_POST['action'] == "add"){
    /**
     * $params array - Массив параметров
     * $fromTable string - Название таблицы в базе данных
     * $needle array - Массив ключей, которые должны присутствовать в массиве $params
     **/
    $needle = ["DEPTH_LEVEL", "CATEGORY", "NAME", "URL"];
    $params = $_POST['params'] = [];
    $fromTable = "menu-" . $_POST['menu-type'];

    DB::AddItem($params, $fromTable, $needle);
}

if ($_POST['action'] == "delete"){
    DB::DeleteItem();
}

if ($_POST['action'] == "update"){
    DB::UpdateItem();
}