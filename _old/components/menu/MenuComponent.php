<?php

class Menu{

    private string $menuFuncCheckKeys = SITE_DIR . "func/checkKeysInArr.php";
    private string $pathToMenuTypes = SITE_DIR . 'components_data/menu/menu_types.json';
    private array $needleKeys = [
        'ID',
        'NAME',
        'URL',
        'CATEGORY',
        'DEPTH_LEVEL',
    ];

    public string $filePath;
    public string $menuComponent;

    function __construct (string $menuComponent)
    {
        if (file_exists($this->pathToMenuTypes) and $file = file_get_contents($this->pathToMenuTypes)){
            $arMenuTypes = json_decode($file, true);
            if (in_array($menuComponent, $arMenuTypes)){
                $this->menuComponent = $menuComponent;
                $this->filePath = SITE_DIR . 'components_data/menu/' . $menuComponent .'/data.json';
            } else {
                echo 'Class Menu - Такого типа меню не существует!';
            }
        } else {
            echo 'Class Menu - Отсутствует файл с типами меню! (' . SITE_DIR . 'components_data/menu/menu_types.json)';
        }

    }

    function addItem(array $newItem):bool
    {
        $this->init();

        if (!checkKeysInArr($newItem, $this->needleKeys)) {
            return false;
        }

        if ($file = file_get_contents($this->filePath)){
            $arMenu = json_decode($file, true);
        }

        foreach ($arMenu as $arItem){
            if ($arItem['ID'] == $newItem['ID']){
                return false;
            }
        }
        $arMenu[] = $newItem;
        return $this->putData($arMenu, $this->filePath);

    }

    function deleteItem($removeId):bool
    {

        $this->init();
        $itemDeleted = false;

        if ($file = file_get_contents($this->filePath)){
            $arMenu = json_decode($file, true);
            foreach ($arMenu as $key => $item){
                if ($item['ID'] == $removeId){
                    unset ($arMenu[$key]);
                    $itemDeleted = true;
                    break;
                }
            }
        } else {
            return false;
        }

        if (!$itemDeleted) return false;

        return $this->putData($arMenu, $this->filePath);

    }

    function updateItem($updateId, array $updateItem):bool
    {
        $this->init();

        $needle = $this->needleKeys;

        foreach ($needle as $key => $item){
            if ($item == 'ID'){
                unset ($needle[$key]);
                break;
            }
        }

        if (!checkKeysInArr($updateItem, $needle)) {
            return false;
        }

        if ($file = file_get_contents($this->filePath)){
            $arMenu = json_decode($file, true);
            foreach ($arMenu as $key => $item){
                if ($item['ID'] == $updateId){
                    $updateItem['ID'] = $item['ID'];
                    $arMenu[$key] = $updateItem;
                    break;
                }
            }
        } else {
            return false;
        }

        return $this->putData($arMenu, $this->filePath);

    }

    function includeComponent()
    {
        if ($file = file_get_contents($this->filePath)) {
            return json_decode($file, true);
        } else {
            return false;
        }
    }

    function addMenuType()
    {
        $this->init();
        $needle = ['MENU_TYPE', 'ID'];
        if ($file = file_get_contents($this->pathToMenuTypes)) {
            $arMenuTypes =  json_decode($file, true);
        } else {
            return false;
        }
        $this->menuComponent;
    }

    private function init()
    {
        $this->makeComponentDataDir();
        if (file_exists($this->menuFuncCheckKeys)){
            require $this->menuFuncCheckKeys;
            return true;
        } else {
            echo "Class Menu - Ошибка: Отсутствует файл " . $this->menuFuncCheckKeys;
        }
    }

    private function putData(array $array, string $path):bool
    {
        $data = json_encode($array);

        if (file_put_contents($path, $data)) {
            return true;
        } else {
            return false;
        }
    }

    private function makeComponentDataDir()
    {
        if (!is_dir(SITE_DIR . 'components_data')){
            mkdir(SITE_DIR . 'components_data');
        }

        if (!is_dir(SITE_DIR . 'components_data/menu')){
            mkdir(SITE_DIR . 'components_data/menu');
        }

        if (!is_dir(SITE_DIR . 'components_data/menu')){
            mkdir(SITE_DIR . 'components_data/menu');
        }

        if (!is_dir(SITE_DIR . 'components_data/menu/' . $this->menuComponent)){
            mkdir(SITE_DIR . 'components_data/menu/' . $this->menuComponent);
        }
    }
}