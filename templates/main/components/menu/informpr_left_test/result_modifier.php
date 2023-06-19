<?php
if (!defined('INIT_INCLUDED')) {
    exit;
}

/*
if ($arItem['DEPTH_LEVEL'] > 1 and !$arItem['PARENT_ID']) {
    unset($arResult['ITEMS'][$key]);
}
*/

$arTemp = $arResult;
unset($arResult);

foreach ($arTemp['ITEMS'] as $key => $arItem){
    if ($arItem['DEPTH_LEVEL'] > 1 and $arItem['PARENT_ID']){
        $arResult['ITEMS'][$arItem['PARENT_ID']]['SUBITEMS'][] = $arItem;
    } else {
        $arResult['ITEMS'][$arItem['ID']]['ITEM'] = $arItem;
    }
}