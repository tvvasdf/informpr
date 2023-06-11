<?php
function checkKeysInArr(array $array, array $needleArrKeys):bool
{
    foreach ($needleArrKeys as $key){
        if (!array_key_exists($key, $array)) return false;
    }

    return true;
}