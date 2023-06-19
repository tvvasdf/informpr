<?php

if (!$arParams['MENU_TYPE']){
    echo 'Ошибка: Не указан обязательный параметр "Тип меню" (MENU_TYPE)';
} else {
        $from = "menu-" . $arParams['MENU_TYPE'];
        $params = [
            "select" => "*",
        ];

        if ($componentTemplate == "default" or !$componentTemplate){
            $pathTempl = SITE_DIR . "/" . SITE_SYSTEM_NAME . "/components/" . $componentName . "/template.php";
            $pathResModifier = SITE_DIR . "/" . SITE_SYSTEM_NAME . "/components/" . $componentName . "/result_modifier.php";
        } else {
            $pathTempl = TEMPLATE_DIR . "/components/" . $componentName . "/" . $componentTemplate . "/template.php";
            $pathResModifier = TEMPLATE_DIR . "/components/" . $componentName . "/" . $componentTemplate . "/result_modifier.php";
        }

        if (!file_exists($pathTempl)){
            echo 'Ошибка: Запрашиваемый шаблон "' . $componentTemplate . '" компонента "' . $componentName . '" не найден.' . $pathTempl;
        } else {

            $result = DB::GetList($params, $from);

            if (is_string($result)){
                echo $result;
            } else {
                $arResult['ITEMS'] = $result->fetchAll(PDO::FETCH_ASSOC);
                if (file_exists($pathResModifier)) {
                    include $pathResModifier;
                }
                include $pathTempl;
            }
        }
    }



