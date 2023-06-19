<?php
if (!defined('INIT_INCLUDED')) {
    exit;
}

$arResult['CATEGORIES_LIST'] = [];

foreach ($arResult['ITEMS'] as $arItem) {
    if (!in_array($arItem['CATEGORY'], $arResult['CATEGORIES_LIST'])) {
        $arResult['CATEGORIES_LIST'][] = $arItem['CATEGORY'];
    }
}
$arResult['CATEGORIES_LIST'] = array_diff($arResult['CATEGORIES_LIST'], [NULL]);

foreach ($arResult['CATEGORIES_LIST'] as $key => $categoryName){
    $arResult['CATEGORIES'][$key]['NAME'] = $categoryName;
    foreach ($arResult['ITEMS'] as $arItem){
        if ($categoryName == $arItem['CATEGORY']){
            $arResult['CATEGORIES'][$key]['ITEMS'][] = $arItem;
        }
    }
}

