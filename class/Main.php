<?php

class Main
{
    private function IncludeCompModel(string $componentName, string $componentTemplate = "default", array $arParams = [], bool $isCustom = false)
    {
        if (!$isCustom){
            $pathComp = SITE_DIR . "/components/" . $componentName . "/component.php";
        } else {
            $pathComp = TEMPLATE_DIR . "/components/" . $componentName . "/component.php";
        }

        if (file_exists($pathComp) && include $pathComp){
            return true;
        }
        else {
            throw new Exception('Запрашиваемый компонент "' . $componentName . '" не найден.');
        }

    }

    public function IncludeComponent(string $componentName, string $componentTemplate = "default", array $arParams = [], bool $isCustom = false)
    {
        try {
            $result = self::IncludeCompModel($componentName, $componentTemplate, $arParams, $isCustom);
        } catch(Exception $e) {
            echo "Ошибка: " . $e->getMessage();
        }
        return $result;
    }
}