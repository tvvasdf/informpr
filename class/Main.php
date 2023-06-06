<?php

class Main
{

    public function IncludeComp(string $componentName, string $componentTemplate = "default", array $arParams = [], bool $isCustom = false)
    {

        if (!$isCustom){
            $pathComp = SITE_DIR . "/components/" . $componentName . "/component.php";
            if ($componentTemplate == "default" or !$componentTemplate){
                $pathTempl = SITE_DIR . "/components/" . $componentName . "/template.php";
            } else {
                $pathComp = TEMPLATE_DIR . "/components/" . $componentName . "/" . $componentTemplate . "/component.php";
            }
        } else {
            $pathTempl = SITE_DIR . "/components/" . $componentName . "/template.php";
            $pathComp = TEMPLATE_DIR . "/components/" . $componentName . "/" . $componentTemplate . "/component.php";
        }

        if (include $pathComp){
            return true;
        }
        else {
            return "Запрашиваемый компонент " . $componentName . " не найден.<br>Путь: " . $pathComp;
        }

    }
}