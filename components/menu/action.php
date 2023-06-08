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

if ($_POST['action'] == "add-menu-type" and $_POST['menu-type']){

    if (DB::ShowTables("menu-" . $_POST['menu-type']) == 0){
        $params = [
            'table_name' => 'menu-' . $_POST['menu-type'],
            'rows' => [
                0 => [
                    'name' => 'ID',
                    'type' => 'INT',
                    'attributes' => [
                        0 => 'AUTO_INCREMENT',
                        1 => 'NOT NULL',
                    ],
                ],

                1 => [
                    'name' => 'NAME',
                    'type' => 'VARCHAR(255)',
                    'attributes' => 'NOT NULL',
                ],

                2 => [
                    'name' => 'URL',
                    'type' => 'VARCHAR(255)',
                    'attributes' => 'NOT NULL',
                ],

                3 => [
                    'name' => 'CATEGORY',
                    'type' => 'VARCHAR(255)',
                    'attributes' => 'NOT NULL',
                ],

                4 => [
                    'name' => 'DEPTH_LEVEL',
                    'type' => 'INT',
                    'attributes' => 'NOT NULL',
                ],

                5 => [
                    'name' => 'PARENT_ID',
                    'type' => 'INT',
                ],
            ],
            'table_attributes' => 'PRIMARY KEY (`ID`)',
        ];

        $result = DB::CreateTable($params);

        if (is_string($result)){
            echo $result;
        }
    }

}