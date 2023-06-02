<?php

class Menu{

    private string $menuFuncCheckKeys = SITE_DIR . "func/checkKeysInArr.php";
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
        if (file_exists(SITE_DIR . 'components/menu/' . $menuComponent .'/index.php')){
            $this->menuComponent = $menuComponent;
            $this->filePath = SITE_DIR . 'components_data/menu/' . $menuComponent .'/data.json';
            echo 'такой компонент существует';
        } else {
            echo 'такого компонента нету!!!';
        }
    }

    function addItem(array $newItem):bool
    {
        $this->init();

        if (!checkKeysInArr($newItem, $this->needleKeys)) {
            return false;
        }

        if ($file = file_get_contents($this->filePath)){
            $arrMenu = json_decode($file, true);
            $arrMenu[] = $newItem;
        } else {
            $arrMenu[] = $newItem;
        }
        return $this->putData($arrMenu, $this->filePath);

    }

    function deleteItem($removeId):bool
    {

        $this->init();

        if ($file = file_get_contents($this->filePath)){
            $arrMenu = json_decode($file);
            foreach ($arrMenu as $key => $item){
                if ($item['ID'] == $removeId){
                    unset ($arrMenu[$key]);
                    break;
                }
            }
        } else {
            return false;
        }

        return $this->putData($arrMenu, $this->filePath);

    }

    function updateItem($updateId, array $updateItem):bool
    {
        $this->init();

        if (checkKeysInArr($updateItem, $this->needleKeys)) {
            return false;
        }

        if ($file = file_get_contents($this->filePath)){
            $arrMenu = json_decode($file);
            foreach ($arrMenu as $key => $item){
                if ($item['ID'] == $updateId){
                    $arrMenu[$key] = $updateItem;
                    break;
                }
            }
        } else {
            return false;
        }

        return $this->putData($arrMenu, $this->filePath);

    }

    function includeComponent()
    {
        if ($file = file_get_contents($this->filePath)) {
            return json_decode($file, true);
        } else {
            return false;
        }
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

    private function putData(array $array, string $path)
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

        if (!is_dir(SITE_DIR . 'components_data/menu' . $this->menuComponent)){
            mkdir(SITE_DIR . 'components_data/menu/' . $this->menuComponent);
        }
    }
}