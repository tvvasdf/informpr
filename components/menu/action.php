<?php
/**
 * $_POST[]
 * 'menu-type' string
 * 'params' array
 * 'action' string
 **/

if ($_POST['action'] == "add"){

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