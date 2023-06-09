<?php
/**
 * $_POST[
 *    'menu-type' string - Тип меню
 *    'params' array - Массив параметров
 *    'action' string - Тип действия
 * ]
 **/

if ($_POST['ACTION'] == "add"){
    /**
     * $params array - Массив параметров
     * $fromTable string - Название таблицы в базе данных
     * $needle array - Массив ключей, которые должны присутствовать в массиве $params
     **/
    $needle = ["DEPTH_LEVEL", "CATEGORY", "NAME", "URL"];
    $postGetData = $_POST;

    if (!$postGetData['NAME'] or !$postGetData['CATEGORY'] or !$postGetData['URL'] or !$postGetData['MENU_TYPE']){
        throw new Exception("Ошибка: Заполнены не все обязательные поля");
    }

    if (!$postGetData['DEPTH_LEVEL']){
        $postGetData['DEPTH_LEVEL'] = 1;
    }

    if (!$postGetData['PARENT_ID']){
        $postGetData['PARENT_ID'] = 0;
    }

    $params = [
        "NAME" => $postGetData['NAME'],
        "CATEGORY" => $postGetData['CATEGORY'],
        "URL" => $postGetData['URL'],
        "DEPTH_LEVEL" => $postGetData['DEPTH_LEVEL'],
    ];
    $fromTable = "menu-" . $postGetData['MENU_TYPE'];

    echo '<pre>';
    var_dump($params);
    echo '</pre>';
    echo '<pre>';
    var_dump($fromTable);
    echo '</pre>';
    //DB::AddItem($params, $fromTable, $needle);
}

if ($_POST['ACTION'] == "delete"){
    DB::DeleteItem();
}

if ($_POST['ACTION'] == "update"){
    DB::UpdateItem();
}

if ($_POST['ACTION'] == "add-menu-type" and $_POST['MENU_TYPE']){

    if (DB::ShowTables("menu-" . $_POST['MENU_TYPE']) == 0){
        $params = [
            'table_name' => 'menu-' . $_POST['MENU_TYPE'],
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