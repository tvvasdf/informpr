<?
$urlArr=explode('/',$_SERVER["REQUEST_URI"]);

$urlArr=array_diff($urlArr, array("")); //чистим массив от пустых значений

$urlArrCount=count($urlArr);

/*
print_r($urlArr);
print_r($urlArrCount);
*/

$urlArrAllVar=
[
    "1" => 'cartridges'
];

if ($urlArr[1]=="cartridges"){
    require_once $_SERVER['DOCUMENT_ROOT']."/url_rewrite/cartridges.php";
}


if (!in_array($urlArr[1],$urlArrAllVar)){
    header("Location: /error/404");
}


?>