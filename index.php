<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/init/header.php";

//$SITE->SetTitle("Главная");

?>

<?
function setTitle($title){	//отложенная функция, принимающая 3 переменные, указанные в body
    $out = ob_get_contents();
    ob_end_clean(); 	//очищаем буфер
    //и продолжаем код после "setTitle('титл','ключи,ключ,ключики','титл с ключами')"
    /*
    echo $title;
    echo $out;//выводим все, что было до "setTitle('титл','ключи,ключ,ключики','титл с ключами')"
    */
    echo $title;
    echo $out;
}
?>

<body>
<h1><?php ob_start();?></h1>
</body>

<?php setTitle('титл') ?>
    <p>Ляляля</p>



<?php

//require_once SITE_DIR . "/include/pages/main/index.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/init/footer.php";