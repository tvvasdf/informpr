<?php

if (!$arParams['MENU_TYPE']){
    echo 'Ошибка: Не указан обязательный параметр "Тип меню" (MENU_TYPE)';
} else {
        $from = "menu-" . $arParams['MENU_TYPE'];
        $params = [
            "select" => "*",
        ];

        if ($componentTemplate == "default" or !$componentTemplate){
            $pathTempl = SITE_DIR . "/components/" . $componentName . "/template.php";
        } else {
            $pathTempl = TEMPLATE_DIR . "/components/" . $componentName . "/" . $componentTemplate . "/template.php";
        }

        if (!file_exists($pathTempl)){
            echo 'Ошибка: Запрашиваемый шаблон "' . $componentTemplate . '" компонента "' . $componentName . '" не найден.';
        } else {

            $result = DB::GetList($params, $from);

            if (is_string($result)){
                echo $result;
            } else {
                $arResult = $result->fetchAll(PDO::FETCH_ASSOC);
                include $pathTempl;
            }
        }
    }


